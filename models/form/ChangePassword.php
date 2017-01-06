<?php

namespace app\models\form;

use app\components\MaClient;
use app\models\User;
use Yii;
use yii\base\Model;

class ChangePassword extends Model
{
    public $oldPassword;
    public $newPassword;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'retypePassword'], 'required'],
        ];
    }

    /**
     * Change password.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function change()
    {
        if ($this->validate()) {
            $baseUrl = Yii::$app->params['urlApi'] . 'change-password';

            $client   = new MaClient();
            $response = $client->post($baseUrl, [
                'oldPassword'    => $this->oldPassword,
                'newPassword'    => $this->newPassword,
                'retypePassword' => $this->retypePassword,
            ])->send();

            $data = [];
            if ($response->isOk) {
                User::saveNewToken($response->data['access']);

                if ($response->data['status'] == 'success') {
                    return true;
                }

                $this->addErrors($response->data['data']);
            }
        }

        return false;
    }
}
