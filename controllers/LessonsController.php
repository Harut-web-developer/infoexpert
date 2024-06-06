<?php

namespace app\controllers;

use Yii;
use app\models\Texts;

class LessonsController extends \yii\web\Controller
{
    public static function pages()
    {
        $page['accounting-for-begginers'] = 21;
        $page['management'] = 22;
        $page['accounting'] = 23;
        $page['marketing'] = 24;
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
    public function actionAccountingForBegginers()
    {
        return $this->render('accouting-for-begginers.php');
    }
    public function actionAccounting()
    {
        return $this->render('accouting');
    }
    public function actionManagement()
    {
        return $this->render('management');
    }
    public function actionMarketing()
    {
        return $this->render('marketing');
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

}
