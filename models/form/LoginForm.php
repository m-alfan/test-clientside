<?php

namespace app\models\form;

use app\components\MaClient;
use app\models\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    private $_user = false;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate() && ($expire = $this->requestLogin())) {
            return Yii::$app->user->login($this->getUser(), time() - $expire);
        }

        return false;
    }

    protected function requestLogin()
    {
        //request login
        $baseUrl = Yii::$app->params['urlApi'] . 'login';

        $client   = new MaClient();
        $response = $client->post($baseUrl, ['username' => $this->username, 'password' => $this->password])->send();

        $data = [];
        if ($response->isOk) {
            if ($response->data['status'] == 'success') {
                $user['User'] = [
                    'username' => $response->data['data']['username'],
                    'token'    => $response->data['data']['token'],
                    'expire'   => $response->data['data']['expire'],
                    'auth_key' => $response->data['data']['auth_key'],
                    'email'    => $response->data['data']['email'],
                ];
                //save user
                $model = User::findByUsername($this->username);
                $model = $model ?: new User($user['User']);

                if ($model->load($user)) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->save()) {
                            $transaction->commit();

                            return $response->data['data']['expire'];
                        }
                    } catch (\Exception $exc) {
                        $model->addError('', $exc->getMessage());
                    }
                    $transaction->rollBack();
                }

                return false;
            }

            $this->addErrors($response->data['data']);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
