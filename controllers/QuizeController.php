<?php

namespace app\controllers;

use app\models\AcQuestionAnswers;
use app\models\AcQuestionList;
use app\models\AcQuestionQuests;
use app\models\AcQuizeLog;
use app\models\User;
use app\models\Users;
use Yii;
use app\models\Texts;

class QuizeController extends \yii\web\Controller
{
    public static function pages()
    {
        $page['index'] = 25;
        $page['trade-management'] = 25;
        $page['result'] = 25;
        return $page;
    }
    public function beforeAction($action)
    {
        // Harut ev Mariam
        if (!isset($_COOKIE['language']) || empty($_COOKIE['language'])) {
            setcookie('language', 'am', time() + (365 * 24 * 60 * 60));
            $this->refresh();
            Yii::$app->end();
            return false;
        }
        $lng = $_COOKIE['language'] ?? 'en';
        if($lng !== 'am' && $lng !== 'ru' && $lng !== 'en'){
            setcookie('language', 'am', time() + (365 * 24 * 60 * 60));
            $this->refresh();
            Yii::$app->end();
            return false;
        }
        $pId = self::pages();
        $txt = Texts::find()
            ->select(['text_'.$lng.' as text']);
        if(@$pId[Yii::$app->controller->action->id]){
            $txt->where(['page_id' => $pId[Yii::$app->controller->action->id]]);
        }
        $txt = $txt->orWhere(['is','page_id' ,null ])
            ->asArray()
            ->indexBy('slug')
            ->column();

        $GLOBALS['text'] = $txt;
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        // Harut ev Mariam
        $session = Yii::$app->session;
        $language = $_COOKIE['language'];
        $quize_name = AcQuestionList::find()
            ->select('id, name_'.$language.' as name')
            ->where(['status' => '1'])
            ->asArray()
            ->all();
        if (!is_null(Yii::$app->user->identity->id)){
            $user = User::findOne(['id' => Yii::$app->user->identity->id, 'status' => '1']);
            if (!is_null($user) && is_null($user->username) && !empty($_POST['name'])) {
                $user->username = $_POST['name'];
                $user->updated_at = date('Y-m-d H:i:s');
            }
            if (!is_null($user) && is_null($user->email) && !empty($_POST['email'])) {
                $user->email = $_POST['email'];
                $user->updated_at = date('Y-m-d H:i:s');
            }
            if (!is_null($user) && is_null($user->phone) && !empty($_POST['phone'])) {
                $user->phone = $_POST['phone'];
                $user->updated_at = date('Y-m-d H:i:s');
            }
            if (!is_null($user) && $user->save(false)) {
                Yii::$app->user->identity->username = $user->username;
                Yii::$app->user->identity->email = $user->email;
                Yii::$app->user->identity->phone = $user->phone;
            }
        }
        elseif (is_null(Yii::$app->user->identity->id) && !isset($_POST['enterQuize'])){
            $session->set('open_popup', true);
        }
        elseif (is_null(Yii::$app->user->identity->id) && isset($_POST['enterQuize'])){
            $session->set('popup_display', 'none');
            $session->set('quizeName',$_POST['name']);
            $session->set('quizePhone',$_POST['phone']);
            $session->set('quizeEmail',$_POST['email']);
        }
        return $this->render('index', [
            'quize_name' => $quize_name,
        ]);
    }
    public function actionQuizeQuestions()
    {
        // Harut
        $id = intval($_GET['id']);
        $language = $_COOKIE['language'];
        $answers = AcQuestionQuests::find()
            ->select([
                'ac_question_quests.id',
                'ac_question_quests.name_'.$language.' as quest_name',
            ])
            ->joinWith([
                'answers' => function($query) use ($language) {
                    $query->select([
                        'id',
                        'name_'.$language.' as answer_name',
                        'status',
                        'order_num',
                        'is_true',
                        'quest_id'
                    ]);
                }
            ])
            ->where(['ac_question_quests.question_id' => $id])
            ->andWhere(['ac_question_quests.status' => '1'])
            ->asArray()
            ->all();
        $answers_list = AcQuestionList::find()->select('id,name_'.$language.' as name_list')
            ->where(['status' => '1'])
            ->andWhere(['id' => $id])
            ->asArray()
            ->one();
        $questions_count = AcQuestionQuests::find()
            ->where(['status' => '1'])
            ->andWhere(['question_id' => $id])
            ->count();

        return $this->render('quize-questions',[
            'answers' => $answers,
            'answers_list' => $answers_list,
            'questions_count' => $questions_count
        ]);

    }
    public function  actionCheck(){
        // Harut
        $session = Yii::$app->session;
        date_default_timezone_set('Asia/Yerevan');
        $ansers = $_POST['answers'];
        $true_answers = 0;
        if(!empty($ansers)){
            for ($i=0; $i< count($ansers);$i++){
                $quest = AcQuestionAnswers::findOne($ansers[$i]);
                if($quest->is_true){
                    $true_answers ++;
                }
            }
        }
        $quizeLog = new AcQuizeLog();
        if (Yii::$app->user->identity){
            $quizeLog->username = Yii::$app->user->identity->username;
            $quizeLog->phone = Yii::$app->user->identity->phone ? Yii::$app->user->identity->phone : $session['quizePhone'];
            $quizeLog->email = Yii::$app->user->identity->email;
        }else{
            $quizeLog->username = $session['quizeName'];
            $quizeLog->phone = $session['quizePhone'];
            $quizeLog->email = $session['quizeEmail'];
        }
        $quizeLog->user_id = Yii::$app->user->identity->id;
        $quizeLog->result = $true_answers;
        $quizeLog->question_id = $_POST['id'];
        $quizeLog->answers = json_encode($ansers);
        $quizeLog->create_date = date('Y-m-d H:i:s');
        $quizeLog->save(false);
        $session->remove('enterQuize');
        return $true_answers;
    }
    public function actionResult()
    {
        // Harut
        $id = intval($_GET['id']);
        $true_answer_count = intval($_GET['count']);
        $language = $_COOKIE['language'];
        $answers_list = AcQuestionList::find()->select('id,name_'.$language.' as name_list')
            ->where(['status' => '1'])
            ->andWhere(['id' => $id])
            ->asArray()
            ->one();
        $questions_count = AcQuestionQuests::find()
            ->where(['status' => '1'])
            ->andWhere(['question_id' => $id])
            ->count();
        return $this->render('result',[
            'answers_list' => $answers_list,
            'questions_count' => $questions_count,
            'true_answer_count' => $true_answer_count
        ]);
    }
}
