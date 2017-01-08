<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config_aws".
 *
 * @property integer $id
 * @property string $region
 * @property string $key
 * @property string $secret
 * @property integer $created_at
 * @property integer $updated_at
 */
class ConfigAws extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_aws';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region', 'key', 'secret'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['region'], 'string', 'max' => 100],
            [['key', 'secret'], 'string', 'max' => 200],
            [['secret'], 'unique'],
            [['key'], 'unique'],
            [['region'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'region'     => 'Region',
            'key'        => 'Key',
            'secret'     => 'Secret',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
