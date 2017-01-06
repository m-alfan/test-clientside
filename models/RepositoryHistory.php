<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repository_history".
 *
 * @property integer $id
 * @property integer $repo_id
 * @property string $commit
 * @property string $author
 * @property string $modified
 * @property string $added
 * @property string $removed
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Repository $repo
 */
class RepositoryHistory extends \yii\db\ActiveRecord
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
        return 'repository_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repo_id', 'commit'], 'required'],
            [['repo_id', 'created_at', 'updated_at'], 'integer'],
            [['modified', 'added', 'removed'], 'string'],
            [['commit', 'author'], 'string', 'max' => 200],
            [['commit'], 'unique'],
            [['repo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repository::className(), 'targetAttribute' => ['repo_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'repo_id'    => 'Repository',
            'commit'     => 'Commit',
            'author'     => 'Author',
            'modified'   => 'Modified',
            'added'      => 'Added',
            'removed'    => 'Removed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepo()
    {
        return $this->hasOne(Repository::className(), ['id' => 'repo_id']);
    }
}
