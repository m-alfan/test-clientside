<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RepositoryHistory */

$this->title = 'Update Repository History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Repository Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="repository-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list
    ]) ?>

</div>
