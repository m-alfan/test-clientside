<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Repository */

$this->title = 'Create Repository';
$this->params['breadcrumbs'][] = ['label' => 'Repositories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repository-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
