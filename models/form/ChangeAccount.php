<?php

namespace app\models\form;

use app\components\MaClient;
use app\models\User;
use Yii;
use yii\base\Model;

class ChangeAccount extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
        ];
    }

    public function change()
    {
        if ($this->validate()) {
            $baseUrl = Yii::$app->params['urlApi'] . 'change-account';

            $client   = new MaClient();
            $response = $client->put($baseUrl, [
                'username' => $this->username,
                'email'    => $this->email,
                'password' => $this->password,
            ])->send();

            $data = [];
            if ($response->isOk) {
                User::saveNewToken($response->data['access']);

                if ($response->data['status'] == 'success') {
                    $user           = Yii::$app->user->identity;
                    $user->username = $this->username;
                    $user->email    = $this->email;
                    $user->save();

                    return true;
                }

                $this->addErrors($response->data['data']);
            }
        }

        return false;
    }
}
