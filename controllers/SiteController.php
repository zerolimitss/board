<?php

namespace app\controllers;

use app\models\Ad;
use app\models\ProfileForm;
use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Ad::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $ads = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("index", compact("ads", "pages"));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Registration action.
     *
     * @return Response|string
     */
    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->singUp()) {
            return $this->goBack();
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionProfile(){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = User::findByUsername(Yii::$app->user->identity->username);
        if ($model->load(Yii::$app->request->post())) {
            $model->photo = UploadedFile::getInstance($model, 'photo');
            $model->save();
            if ($model->photo) {
                if ($model->validate()) {
                    $model->photo->saveAs(Yii::getAlias("@webroot").'/images/' . $model->photo->baseName . '.' . $model->photo->extension);
                }
            }
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionAdd(){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Ad();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Your advertisement has been added!');
            return $this->redirect(['site/add']);
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionDeletePhoto(){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = User::findByUsername(Yii::$app->user->identity->username);
        unlink(Yii::getAlias("@webroot") . '/images/' . $model->photo);
        $model->photo = "";
        $model->save();

        return $this->redirect(['site/profile']);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
