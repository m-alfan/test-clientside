<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Repository */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Repositories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repository-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url_git:url',
            'description:ntext',
            'local_path',
            'branch',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:F j, Y H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:F j, Y H:i:s']
            ],
        ],
    ]) ?>

</div>
