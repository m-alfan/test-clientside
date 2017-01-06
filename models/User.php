<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'token', 'auth_key', 'email'], 'required'],
            [['expire'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['token', 'email'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'username' => 'Username',
            'token'    => 'Token',
            'expire'   => 'Expire',
            'auth_key' => 'Auth Key',
            'email'    => 'Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->where(['OR', ['username' => $username], ['email' => $username]])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Save new token
     */
    public static function saveNewToken($access)
    {
        $user         = Yii::$app->user->identity;
        $user->token  = $access['token'];
        $user->expire = $access['expired'];
        if ($user->save()) {
            return true;
        }

        return false;
    }
}
