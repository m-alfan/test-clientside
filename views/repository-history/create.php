<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RepositoryHistory */

$this->title = 'Create Repository History';
$this->params['breadcrumbs'][] = ['label' => 'Repository Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repository-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list
    ]) ?>

</div>
