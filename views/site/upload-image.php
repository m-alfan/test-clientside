<?php

use yii\helpers\Html;
use dosamigos\fileupload\FileUploadUI;

$this->title = 'Upload Image';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-upload">
    <?= FileUploadUI::widget([
        'model' => $model,
        'attribute' => 'imageFile',
        'url' => ['upload-image'],
        'gallery' => false,
        'fieldOptions' => [
            'accept' => 'image/*'
        ],
        'clientOptions' => [
            'maxFileSize' => 1024 * 1024 * 5 // 5mb
        ],
    ])?>
</div>
<?php

$customCss = <<< SCRIPT
    .fileupload-buttonbar {
        margin-bottom: 50px;
    }
    .preview {display: inline-block;
        overflow: hidden;
        width:80px;
        height:40px;
    }
SCRIPT;
$this->registerCss($customCss);
?>
