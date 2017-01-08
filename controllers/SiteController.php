<?php

namespace app\controllers;

use app\components\AuthFilter;
use app\components\Controller;
use app\models\AwsS3;
use app\models\ConfigAws;
use app\models\UploadFile;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'auth'  => [
                'class' => AuthFilter::className(),
                'only'  => ['upload-image', 'list-image', 'delete', 'delete-one'],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'     => ['post'],
                    'delete-one' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
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
        return $this->render('index');
    }

    public function actionUploadImage()
    {
        //cek data aws
        if (ConfigAws::findOne(1) === null) {
            $aws = new ConfigAws();

            if ($aws->load(Yii::$app->request->post()) && $aws->save()) {
                return $this->redirect(['upload-image']);
            }

            return $this->render('aws', ['model' => $aws]);
        }

        $model = new UploadFile();

        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        $directory        = 'upload' . DIRECTORY_SEPARATOR;
        $directoryThumb   = 'upload' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
        if ($model->imageFile) {
            $uid       = uniqid(time(), true);
            $fileName  = $uid . '.' . $model->imageFile->extension;
            $filePath  = $directory . $fileName;
            $thumbPath = $directoryThumb . $fileName;

            if ($model->imageFile->saveAs($filePath)) {
                $size = $model->imageFile->size;
                //thumb
                Image::thumbnail($filePath, 60, 60)->save($thumbPath, ['quality' => 100]);

                //upload image
                $s3        = new AwsS3();
                $fileUrl   = $s3->uploadObject($filePath, 'test-alfan', 'test-programmer/' . $fileName);
                $fileThumb = $s3->uploadObject($filePath, 'test-alfan', 'test-programmer/thumb/' . $fileName);

                $model->name      = $fileName;
                $model->path      = $fileUrl;
                $model->thumb     = $fileThumb;
                $model->imageFile = null;

                if ($model->save()) {
                    return Json::encode([
                        'files' => [[
                            'name'         => $fileName,
                            'size'         => $size,
                            "url"          => $fileUrl,
                            "thumbnailUrl" => $fileThumb,
                            "deleteUrl"    => Url::to(['delete', 'id' => $model->id], true),
                            "deleteType"   => "POST",
                        ]],
                    ]);
                } else {
                    return Json::encode([
                        'files' => [[
                            'name' => 'Cannot upload to server',
                        ]],
                    ]);
                }
            } else {
                $error = isset($model->errors['imageFile']) ? implode(",", $model->errors['imageFile']) : 'error';
                return Json::encode([
                    'files' => [[
                        'name' => $error,
                    ]],
                ]);
            }

            return $this->redirect(['index']);
        }

        return $this->render('upload-image', [
            'model' => $model,
        ]);
    }

    public function actionListImage()
    {
        $model = UploadFile::find()->all();
        return $this->render('list-image', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = UploadFile::findOne($id);
        $s3    = new AwsS3();

        if (is_file(Yii::getAlias('@webroot/upload/') . $model->name)) {
            $s3->deleteObject('test-alfan', 'test-programmer/' . $model->name);
            unlink(Yii::getAlias('@webroot/upload/') . $model->name);

        }

        if (is_file(Yii::getAlias('@webroot/upload/thumb/') . $model->name)) {
            $s3->deleteObject('test-alfan', 'test-programmer/thumb/' . $model->name);
            unlink(Yii::getAlias('@webroot/upload/thumb/') . $model->name);
        }

        $delete = $model->delete();

        if (Yii::$app->request->isAjax && $delete) {
            return true;
        }

        return $this->redirect(['list-image']);
    }
}
