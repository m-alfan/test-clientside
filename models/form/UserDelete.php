<?php

namespace app\models\form;

use app\components\MaClient;
use app\models\User;
use Yii;
use yii\base\Model;

class UserDelete extends Model
{
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
        ];
    }

    public function deleteAccount()
    {
        $baseUrl = Yii::$app->params['urlApi'] . 'delete';

        $client   = new MaClient();
        $response = $client->delete($baseUrl, ['username' => $this->username])->send();

        $data = [];
        if ($response->isOk) {
            User::saveNewToken($response->data['access']);

            if ($response->data['status'] == 'success') {
                return true;
            }

            $this->addErrors($response->data['data']);
        }

        return false;
    }
}
