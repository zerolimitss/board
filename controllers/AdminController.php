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

class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionProfile(){

        $model = User::findByUsername(Yii::$app->user->identity->username);
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->save();
            if ($model->image) {
                if ($model->validate()) {
                    $model->image->saveAs(Yii::getAlias("@webroot").'/images/' . $model->image->baseName . '.' . $model->image->extension);
                }
            }
            return $this->redirect(['admin/profile']);
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionAdd(){

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

        $model = User::findByUsername(Yii::$app->user->identity->username);
        unlink(Yii::getAlias("@webroot") . '/images/' . $model->photo);
        $model->photo = "";
        $model->save();

        return $this->redirect(['admin/profile']);
    }
}
