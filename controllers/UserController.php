<?php

namespace app\controllers;

use app\components\AuthFilter;
use app\components\Controller;
use app\components\MaClient;
use app\models\form\ChangeAccount;
use app\models\form\ChangePassword;
use app\models\form\LoginForm;
use app\models\form\SignUp;
use app\models\form\UserDelete;
use app\models\form\UserForm;
use app\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'auth' => [
                'class' => AuthFilter::className(),
                'only'  => ['index', 'change-password', 'change-account', 'delete'],
            ],
        ];
    }

    public function actionIndex()
    {
        $baseUrl = Yii::$app->params['urlApi'] . 'user';

        $paramSearch = Yii::$app->request->queryParams;

        //data model
        $searchModel = new UserForm();
        $searchModel->load($paramSearch);

        //request rest api
        $client   = new MaClient();
        $response = $client->get($baseUrl, $paramSearch)->send();

        $data = [];
        if ($response->isOk && $response->data['status'] == 'success') {
            $data = $response->data['data'];
            User::saveNewToken($response->data['access']);
        } else {
            throw new NotFoundHttpException('Cannot get data from server.');
        }

        $dataProvider = new ArrayDataProvider([
            'allModels'  => $data['dataModels'],
            'totalCount' => $data['totalCount'],
            'pagination' => [
                'page'     => $data['page'] - 1,
                'pageSize' => $data['pageSize'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignUp();
        if ($model->load(Yii::$app->request->post()) && $model->signupAccount()) {
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePassword();

        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            return $this->goBack();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionChangeAccount()
    {
        $user  = Yii::$app->user->identity;
        $model = new ChangeAccount([
            'username' => $user->username,
            'email'    => $user->email,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            return $this->goBack();
        }

        return $this->render('change-account', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $model = new UserDelete();

        if ($model->load(Yii::$app->request->post()) && $model->deleteAccount()) {
            Yii::$app->user->logout();
            return $this->goHome();
        }

        return $this->render('delete', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
