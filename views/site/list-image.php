<?php

use yii\helpers\Html;

$this->title = 'List Image';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-list">
    <?php
        $items = [];
        foreach ($model as $value) {
            $items[] = [
                'url'           => $value->path,
                'src'           => $value->thumb,
                'options'       => ['title' => $value->name],
                'imageOptions'  => ['width' => '100px'],
                'deleteUrl'     => ['delete', 'id' => $value->id],
                'deleteOptions' => [
                    'data-method'  => 'post',
                    'data-confirm' => 'Are you sure you want to delete this item?',
                    'style'        => 'margin-left: -7px; margin-top: -5px; position: absolute; background-color:#C9302C; border-radius:50%; padding: 2px 6px; color:#FFFFFF; text-decoration:none;',
                ],
            ];
        }

        if (empty($items)) {
            echo 'No results found.';
        } else {
            echo \app\components\MaGallery::widget(['items' => $items]);
        }
    ?>
</div>