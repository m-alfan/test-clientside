<?php

namespace app\controllers;

use app\components\AuthFilter;
use app\components\Controller;
use app\models\Repository;
use app\models\RepositoryHistory;
use app\models\RepositoryHistorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * RepositoryHistoryController implements the CRUD actions for RepositoryHistory model.
 */
class RepositoryHistoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'auth'  => [
                'class' => AuthFilter::className(),
                'only'  => ['index', 'update', 'create', 'view', 'delete'],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RepositoryHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new RepositoryHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $list = ArrayHelper::map(Repository::find()->asArray()->all(), 'id', 'name');

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'list'         => $list,
        ]);
    }

    /**
     * Displays a single RepositoryHistory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RepositoryHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RepositoryHistory();

        $list = ArrayHelper::map(Repository::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'list'  => $list,
            ]);
        }
    }

    /**
     * Updates an existing RepositoryHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $list = ArrayHelper::map(Repository::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'list'  => $list,
            ]);
        }
    }

    /**
     * Deletes an existing RepositoryHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RepositoryHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RepositoryHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RepositoryHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
