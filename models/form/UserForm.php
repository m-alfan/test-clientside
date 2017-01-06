<?php
namespace app\models\form;

use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $email;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'email'], 'safe'],
        ];
    }
}
