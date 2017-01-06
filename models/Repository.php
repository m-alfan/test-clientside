<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repository".
 *
 * @property integer $id
 * @property string $name
 * @property string $url_git
 * @property string $description
 * @property string $local_path
 * @property string $branch
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RepositoryHistory[] $repositoryHistories
 */
class Repository extends \yii\db\ActiveRecord
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
        return 'repository';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url_git', 'local_path', 'branch'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['url_git'], 'url', 'defaultScheme' => 'http'],
            [['name'], 'string', 'max' => 100],
            [['url_git', 'branch', 'local_path'], 'string', 'max' => 200],
            [['url_git'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Repository',
            'url_git'     => 'Url Git',
            'description' => 'Description',
            'local_path'  => 'Local Path',
            'branch'      => 'Branch',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepositoryHistories()
    {
        return $this->hasMany(RepositoryHistory::className(), ['repo_id' => 'id']);
    }
}
