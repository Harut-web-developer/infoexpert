<?php

namespace app\controllers;

use app\models\AcInfo;
use Yii;
use app\models\Texts;

class ContactUsController extends \yii\web\Controller
{
    public static function pages()
    {
        $page['index'] = 17;
        return $page;
    }
    public function beforeAction($action)
    {
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
        if($this->request->isPost && isset($_POST['name'])){
            $email = 'user2002mm@gmail.com';
            $post = $this->request->post();
            $senderEmail = $post['email'];
            $subject = "Contact us";
            $message = $post['comment'];
            $result = Yii::$app->mailer->compose('welcome', ['message' => $message])
                ->setFrom($senderEmail)
                ->setTo($email)
                ->setSubject($subject)
                ->send();
        }
        $info = AcInfo::findOne(['status' => '1']);
        return $this->render('index',['info' => $info]);
    }
}
