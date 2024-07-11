<?php

namespace app\controllers;

use app\models\AcAnswers;
use app\models\AcLessons;
use app\models\AcPartners;
use app\models\AcQuestionAnswers;
use app\models\AcQuestionList;
use app\models\AcQuestionQuests;
use app\models\AcReviews;
use app\models\FsOrders;
use app\models\AcBlog;
use app\models\FsSettings;
use app\models\FsTexts;
use app\models\User;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\helpers\ArrayHelper;

use DateInterval;
use DatePeriod;
use DateTime;
class AdminController extends Controller {
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        $this->layout = 'admin';
        return parent::beforeAction($action);

    }
    public function behaviors() {
        return ['access' => ['class' => AccessControl::className(), 'only' => ['index'], 'rules' => [['actions' => ['login'], 'allow' => true, 'roles' => ['@', ], ], ['actions' => ['index'], 'allow' => true, 'roles' => ['@', ], ], ], ], 'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post', 'get'], 'dashboard-only' => ['post', 'get'], ], ], ];
    }
    public function actions() {
        return ['error' => ['class' => 'yii\web\ErrorAction', ], 'captcha' => ['class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null, ], ];
    }
    /* PAGES BLOCK */
    /*HOME ACTION*/
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        return $this->render('index');
    }
    public function actionQuestions() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $question = new AcQuestionList();
            $question->load($post);
            $question->save(false);
            $this->redirect(['questions', 'success' => 'true', 'id' => 'key' . $question->id]);
        }
        $questions = AcQuestionList::find()->all();
        return $this->render('questions', ['questions' => $questions]);

    }
    public function actionQuestion() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $question = new AcQuestionQuests();
            $question->load($post);
            $question->save(false);
            $this->redirect(['question', 'success' => 'true', 'id' => $id]);
        }
        $answers = AcQuestionQuests::find()->where(['question_id'=>$id])->all();
        $question = AcQuestionList::findOne($id);
        return $this->render('question', ['answers' => $answers,'question'=>$question]);

    }
    public function actionAnswer() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $question = new AcQuestionAnswers();
            $question->load($post);
            $question->save(false);
            $this->redirect(['answer', 'success' => 'true', 'id' => $id]);
        }
        $answers = AcQuestionAnswers::find()->where(['quest_id'=>$id])->all();
        $question = AcQuestionQuests::findOne($id);
        return $this->render('answer', ['answers' => $answers,'question'=>$question]);

    }
    /*CUSTOMERS PAGE ACTION EDITE|DELETE|CREATE|COPY*/
    public function actionCustomers() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $user = new User();
            $user->load($post);
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
            $user->save(false);
            $this->redirect(['customers', 'success' => 'true', 'id' => 'key' . $user->id]);
        }
        else if ($post && $post['edite']) {
            $user = User::findOne(['id' => intval($post['id']) ]);
            $pass = $user->password;
            $user->load($post);
            if($post['FsUsers']['password']) {
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
            } else {
                $user->password = $pass;
            }
            if (!empty($_FILES['logo']) && $_FILES["logo"]["name"]) {
                $tmp_name = $_FILES["logo"]["tmp_name"];
                $name = time() . basename($_FILES["logo"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/users/$name");
                $user->image = "web/uploads/users/$name";
            }
            $user->save(false);
            $this->redirect(['customers', 'success' => 'true', 'id' => 'key' . $user->id]);
        }
        $page = intval($_GET['page']);
        $limit = 10;
        $offset = 0;
        if ($page) {
            $offset = $limit * $page;
        }
        if (!isset($_GET['search'])) {
            if ($page != 'all') {
                $users = User::find()->limit($limit)->offset($offset)->orderBy(['created_at' => SORT_ASC])->all();
            }
            else {
                $users = User::find()->orderBy(['created_at' => SORT_ASC])->all();
            }
        }
        else {
            switch (intval($_GET['type'])) {
                case 2:
                    $cond = ' legal_name LIKE "%' . $_GET['search'] . '"';
                    break;
                case 1:
                    $cond = ' legal_name LIKE "' . $_GET['search'] . '%"';
                    break;
                case 3:
                    $cond = ' legal_name LIKE "%' . $_GET['search'] . '%" AND legal_name NOT LIKE  "%' . $_GET['search'] . '" AND legal_name NOT LIKE "' . $_GET['search'] . '%"';
                    break;
                default:
                    $cond = ' legal_name LIKE "%' . $_GET['search'] . '%"';
                    break;
            }
            $users = User::find()->where($cond)->all();
        }

        $total = User::find()->count();
        return $this->render('customers', ['partners' => $users, 'total' => $total]);
    }
    public function actionPartners() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $partner = new AcPartners();
            $partner->load($post);
            if (!empty($_FILES['logo']) && $_FILES["logo"]["name"]) {
                $tmp_name = $_FILES["logo"]["tmp_name"];
                $name = time() . basename($_FILES["logo"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/$name");
                $partner->img = "web/uploads/$name";
            }
            if (!empty($_FILES['logo_black']) && $_FILES["logo_black"]["name"]) {
                $tmp_name = $_FILES["logo_black"]["tmp_name"];
                $name = time() . basename($_FILES["logo_black"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/$name");
                $partner->img_black = "web/uploads/$name";
            }
            $partner->save(false);
            $this->redirect(['partners', 'success' => 'true', 'id' => 'key' . $partner->id]);
        }
        else if ($post && $post['edite']) {
            $partner = AcPartners::findOne(['id' => intval($post['id']) ]);

            $partner->load($post);

            if (!empty($_FILES['logo']) && $_FILES["logo"]["name"]) {
                $tmp_name = $_FILES["logo"]["tmp_name"];
                $name = time() . basename($_FILES["logo"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/$name");
                $partner->img = "web/uploads/$name";
            }
            if (!empty($_FILES['logo_black']) && $_FILES["logo_black"]["name"]) {
                $tmp_name = $_FILES["logo_black"]["tmp_name"];
                $name = time() . basename($_FILES["logo_black"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/$name");
                $partner->img_black = "web/uploads/$name";
            }
            $partner->save(false);
            $this->redirect(['partners', 'success' => 'true', 'id' => 'key' . $partner->id]);
        }

        $partners = AcPartners::find()->orderBy(['order_num' => SORT_ASC])->all();
        return $this->render('partners', ['partners' => $partners]);
    }
    public function actionAnswers() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $answer = new AcAnswers();
            $answer->load($post);

            $answer->save(false);
            $this->redirect(['answers', 'success' => 'true', 'id' => 'key' . $answer->id]);
        }
        else if ($post && $post['edite']) {
            $answer = AcAnswers::findOne(['id' => intval($post['id']) ]);
            $answer->load($post);
            $answer->save(false);
            $this->redirect(['answer', 'success' => 'true', 'id' => 'key' . $answer->id]);
        }
        $answers = AcAnswers::find()->orderBy(['order_num' => SORT_ASC])->all();
        return $this->render('answers', ['answers' => $answers]);
    }

    /*SITE PAGES PAGE ACTION EDITE|DELETE|CREATE|COPY*/
    public function actionBlog() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $page = new AcBlog();
            $page->load($post);
            $page->url = $this->transLateURRL($page->page_title_am);
            if (!empty($_FILES['img']) && $_FILES["img"]["name"]) {
                $tmp_name = $_FILES["img"]["tmp_name"];
                $name = time() . basename($_FILES["img"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/$name");
                $page->img = "web/uploads/$name";
            }
            $page->save(false);
            $this->redirect(['blog', 'success' => 'true', 'id' => 'key' . $page->id]);
        }
        else if ($post && $post['edite']) {
            $page = AcBlog::findOne(['id' => intval($post['id']) ]);
            $page->load($post);
            $page->url = $this->transLateURRL($page->page_title_am);
            if (!empty($_FILES['img']) && $_FILES["img"]["name"]) {
                $tmp_name = $_FILES["img"]["tmp_name"];
                $name = time() . basename($_FILES["img"]["name"]);
                move_uploaded_file($tmp_name, "web/uploads/$name");
                $page->img = "web/uploads/$name";
            }
            $page->save(false);
            $this->redirect(['blog', 'success' => 'true', 'id' => 'key' . $page->id]);
        }
        $pages = AcBlog::find()->orderBy(['order_num' => SORT_ASC])->all();
        return $this->render('blog', ['pages' => $pages]);
    }
    public function actionLessons() {

        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $lesson = new AcLessons();
            $lesson->load($post);
            $lesson->save(false);
            $this->redirect(['lessons', 'success' => 'true', 'id' => 'key' . $lesson->id]);
        }
        else if ($post && $post['edite']) {
            $lesson = AcLessons::findOne(['id' => intval($post['id']) ]);
            $lesson->load($post);
            $lesson->save(false);
            $this->redirect(['lessons', 'success' => 'true', 'id' => 'key' . $lesson->id]);
        }
        $lessons = AcLessons::find()->orderBy(['order_num' => SORT_ASC])->all();
        return $this->render('lessons', ['lessons' => $lessons]);
    }
    public function actionBlog_() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $page = new AcBlog();
            $page->load($post);
            $page->save(false);
            $this->redirect(['blog', 'success' => 'true', 'id' => 'key' . $page->id]);
        }
        else if ($post && $post['edite']) {
            $page = AcBlog::findOne(['id' => intval($post['id']) ]);
            $page->load($post);
            $page->save(false);
            $this->redirect(['blog', 'success' => 'true', 'id' => 'key' . $page->id]);
        }
        $pages = AcBlog::find()->orderBy(['order_num' => SORT_ASC])->all();
        return $this->render('blog', ['pages' => $pages]);
    }
    public function actionReviews() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['add']) {
            $review = new AcReviews();
            $review->load($post);
            $review->save(false);
            $this->redirect(['reviews', 'success' => 'true', 'id' => 'key' . $review->id]);
        }
        else if ($post && $post['edite']) {
            $review = AcReviews::findOne(['id' => intval($post['id']) ]);
            $review->load($post);
            $review->save(false);
            $this->redirect(['reviews', 'success' => 'true', 'id' => 'key' . $review->id]);
        }
        $reviews = AcReviews::find()->orderBy(['order_num' => SORT_ASC])->all();
        return $this->render('reviews', ['reviews' => $reviews]);
    }

    /*Texts PAGE ACTION EDITE|DELETE|CREATE|COPY*/
    public function actionTexts() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['edite']) {
            $text = FsTexts::findOne(['id' => intval($post['id']) ]);
            $text->load($post);
            $text->save(false);
            $this->redirect(['texts', 'success' => 'true','page'=>$_GET['page'], 'id' => 'key' . $text->id]);
        }
        $page = $_GET['page'];
        $limit = 10;
        $offset = 0;
        $cond = [];
        if ($page) {
            $offset = $limit * $page;
        }
        $sql = '';
        $cond = '';
        if(isset($_GET['search'])){
            switch (intval($_GET['type'])) {
                case 2:
                    $cond = ' text_am LIKE "%' . $_GET['search'] . '"';
                    break;
                case 1:
                    $cond = ' text_am LIKE "' . $_GET['search'] . '%"';
                    break;
                case 3:
                    $cond = ' text_am LIKE "%' . $_GET['search'] . '%" AND text_am NOT LIKE  "%' . $_GET['search'] . '" AND text_am NOT LIKE "' . $_GET['search'] . '%"';
                    break;
                default:
                    $cond = ' text_am LIKE "%' . $_GET['search'] . '%"';
                    break;
            }
        }
        if( $page != 'all') {
            $texts = FsTexts::find()->andWhere($cond)->limit($limit)->offset($offset)->orderBy(['id' => SORT_DESC])->all();
            $total = FsTexts::find()->andWhere($cond)->count();
        } else {
            $texts = FsTexts::find()->andWhere($cond)->orderBy(['id' => SORT_DESC])->all();
            $total = FsTexts::find()->andWhere($cond)->count();
        }
        return $this->render('texts', ['texts' => $texts, 'total' => $total]);
    }


    /*SETTINGS PAGE ACTION EDITE|DELETE|CREATE|COPY*/
    public function actionSettings() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $post = Yii::$app->request->post();
        if ($post && $post['edite']) {
            $settings = FsSettings::findOne(['id' => 1]);
            $settings->load($post);
            if (isset($_FILES['img'])) {
                $uploaddir = 'web/uploads/';
                $uploadfile = $uploaddir . time() . basename($_FILES['img']['name']);
                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
                    $settings->site_logo = $uploadfile;
                }
            }
            if (isset($_FILES['sitemap'])) {
                $uploaddir = 'web/uploads/';
                $uploadfile = $uploaddir . time() . basename($_FILES['sitemap']['name']);
                if (move_uploaded_file($_FILES['sitemap']['tmp_name'], $uploadfile)) {
                    $settings->sitemap = $uploadfile;
                }
            }
            $settings->save(false);
            $this->redirect(['settings', 'success' => 'true', 'id' => 'key1']);
        }
        else if ($post && $post['add']) {
            $user = new Users();
            $user->load($post);
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
            $user->auth_key = substr($user->password, 0, 30);
            $user->save(false);
            $this->redirect(['settings', 'success' => 'true', 'id' => 'key1']);
        }  else if ($post && $post['edite_sec']) {
            $user = Users::findOne(['id'=>intval($post['id'])]);
            $user->load($post);
            if($post['Users']['password']) {
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
            }
            $user->save(false);
            $this->redirect(['settings', 'success' => 'true', 'id' => 'key1']);
        } else if ($post && $post['add_sec']) {
            $user = new Users();
            $user->load($post);
            if($post['Users']['password']) {
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
            } else {
                $user->password = $post['old_password'];
            }
            $user->auth_key = substr($user->password, 0, 30);
            $user->save(false);
            $this->redirect(['settings', 'success' => 'true', 'id' => 'key1']);
        }
        $id = intval(1);
        $settings = FsSettings::findOne(['id' => $id]);
        $users = Users::find()->all();
        return $this->render('settings', ['settings' => $settings, 'users' => $users]);
    }




    /* EDITE BLOCK */


    public function actionTextEdite() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $text = FsTexts::findOne(['id' => $id]);
        return $this->renderAjax('text-edite-popup', ['text' => $text]);
    }

    public function actionBlogEdite() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $page = AcBlog::findOne(['id' => $id]);
        return $this->renderAjax('page-edite-popup', ['page' => $page]);
    }
    public function actionPartnerEdite() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $partner = AcPartners::findOne(['id' => $id]);
        return $this->renderAjax('partner-edite-popup', ['partner' => $partner]);
    }
    public function actionLessonEdite() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $lesson = AcLessons::findOne(['id' => $id]);
        return $this->renderAjax('lesson-edite-popup', ['lesson' => $lesson]);
    }
    public function actionAnswerhthEdite() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $answer = AcAnswers::findOne(['id' => $id]);
        return $this->renderAjax('answer-edite-popup', ['answer' => $answer]);
    }
    public function actionReviewEdite() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['admin/login']);
        }
        $id = intval($_GET['id']);
        $review = AcReviews::findOne(['id' => $id]);
        return $this->renderAjax('review-edite-popup', ['review' => $review]);
    }

      /* DISABLE BLOCK */

    public function actionPartnerDisable() {
        $id = intval($_GET['id']);
        $partner = AcPartners::findOne(['id' => $id]);
        if ($partner->status) {
            $partner->status = 0;
        }
        else {
            $partner->status = 1;
        }

        $partner->save(false);
        return true;
    }
    public function actionQuestionsDisable() {
        $id = intval($_GET['id']);
        $questions = AcQuestionList::findOne(['id' => $id]);
        if ($questions->status) {
            $questions->status = 0;
        }
        else {
            $questions->status = 1;
        }

        $questions->save(false);
        return true;
    }
    public function actionAnswerhthDisable() {
        $id = intval($_GET['id']);
        $answer = AcAnswers::findOne(['id' => $id]);
        if ($answer->status) {
            $answer->status = 0;
        }
        else {
            $answer->status = 1;
        }

        $answer->save(false);
        return true;
    }
    public function actionAnswerDisable() {
        $id = intval($_GET['id']);
        $answer = AcQuestionAnswers::findOne(['id' => $id]);
        if ($answer->status) {
            $answer->status = 0;
        }
        else {
            $answer->status = 1;
        }

        $answer->save(false);
        return true;
    }
    public function actionLessonDisable() {
        $id = intval($_GET['id']);
        $lesson = AcLessons::findOne(['id' => $id]);
        if ($lesson->status) {
            $lesson->status = 0;
        }
        else {
            $lesson->status = 1;
        }

        $lesson->save(false);
        return true;
    }
    public function actionQuestDisable() {
        $id = intval($_GET['id']);
        $quest = AcQuestionQuests::findOne(['id' => $id]);
        if ($quest->status) {
            $quest->status = 0;
        }
        else {
            $quest->status = 1;
        }

        $quest->save(false);
        return true;
    }
    public function actionReviewDisable() {
        $id = intval($_GET['id']);
        $review = AcReviews::findOne(['id' => $id]);
        if ($review->status) {
            $review->status = 0;
        }
        else {
            $review->status = 1;
        }

        $review->save(false);
        return true;
    }
    public function actionBlogDisable() {
        $id = intval($_GET['id']);
        $blog = AcBlog::findOne(['id' => $id]);
        if ($blog->status) {
            $blog->status = 0;
        }
        else {
            $blog->status = 1;
        }

        $blog->save(false);
        return true;
    }



    public function actionUserDisable() {
        $id = intval($_GET['id']);
        $item = Users::findOne(['id' => $id]);
        if ($item->status) {
            $item->status = 0;
        }
        else {
            $item->status = 1;
        }
        $item->save(false);
        return true;
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(array('index'));
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(array('index'));
        }
        $model->password = '';
        return $this->render('login', ['model' => $model, ]);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public  function  transLateURRL($rdata){

        $rdata = str_replace(' ', '-', $rdata);
        $rdata = str_replace('×', '_', $rdata);
        $rdata = str_replace('^', '_', $rdata);
        $rdata = str_replace('%', '_', $rdata);
        $rdata = str_replace('(', '_', $rdata);
        $rdata = str_replace(')', '_', $rdata);
        $rdata = str_replace('/', '_', $rdata);
        $rdata = str_replace('\\', '_', $rdata);
        $rdata = str_replace('#', '_', $rdata);
        $rdata = str_replace('՝', '', $rdata);
        $rdata = str_replace('։', '_', $rdata);
        $rdata = str_replace(',', '_', $rdata);
        $rdata = str_replace('-', '_', $rdata);
        $rdata = str_replace('$', '_', $rdata);
        $rdata = str_replace('@', '_', $rdata);
        $rdata = str_replace('&', '_', $rdata);
        $rdata = str_replace('=', '_', $rdata);
        $rdata = str_replace(',', '_', $rdata);
        $rdata = str_replace('«', '', $rdata);
        $rdata = str_replace('»', '', $rdata);
        $rdata = str_replace('֊', '_', $rdata);
        $rdata = str_replace('__', '_', $rdata);
        $rdata = str_replace('+', '_', $rdata);
        $rdata = str_replace('"', '_', $rdata);
        $rdata = str_replace("'", '_', $rdata);
        $cyr = [
            'ա','բ','վ','գ','դ','ե','ժ','զ','ի','յ','կ','լ','մ','ն','օ','պ',
            'ռ','ս','տ','ու','փ','խ','ց','չ','շ','է','ը','ո','ր','և','ք','ջ','ծ','ղ','հ','ճ','թ','ֆ','ձ','ւ',
            'Ա','Բ','Վ','Գ','Դ','Ե','Ժ','Զ','Ի','Յ','Կ','Լ','Մ','Ն','Օ','Պ',
            'Ռ','Ս','Տ','ՈՒ','Փ','Խ','Ց','Չ','Շ','Է','Ը','Ո','Ր','և','Ք','Ջ','Ծ','Ղ','Հ','Ճ','Թ','Ֆ','Ձ'
        ];

        $lat = [
            'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','ph','x','ts','ch','sh','e','y','o','r','ev','q','j','ts','x','h','j','t','f','zh','v',
            'A','B','V','G','D','E','ZH','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','PH','X','TS','CH','SH','E','Y','VO','R','EV','Q','J','TS','X','H','J','T','F','ZH'
        ];

        $rdata = str_replace($cyr, $lat, $rdata);
        return strtolower($rdata);
    }

    public function getresultTree(array $elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->getresultTree($elements, $element['id']);
                if ($children) {
                    $element['child'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(array('login'));
    }
    /**
     * Displays contact page.
     *
     * @return Response|string
     */
}