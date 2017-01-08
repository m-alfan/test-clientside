<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $thumb
 */
class UploadFile extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upload_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'thumb'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['path', 'thumb'], 'string', 'max' => 200],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 5], //5 mb
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'      => 'Name',
            'path'      => 'Path',
            'thumb'     => 'Thumb',
            'imageFile' => 'Image',
        ];
    }
}
