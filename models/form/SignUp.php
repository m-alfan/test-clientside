<?php

namespace app\models\form;

use app\components\MaClient;
use Yii;
use yii\base\Model;

class SignUp extends Model
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
            [['username', 'password', 'email'], 'required'],
        ];
    }

    public function signupAccount()
    {
        $baseUrl = Yii::$app->params['urlApi'] . 'signup';

        $client   = new MaClient();
        $response = $client->put($baseUrl, [
            'username' => $this->username,
            'email'    => $this->email,
            'password' => $this->password,
        ])->send();

        $data = [];
        if ($response->isOk) {
            if ($response->data['status'] == 'success') {
                return true;
            }

            $this->addErrors($response->data['data']);
        }

        return false;
    }
}
