<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RepositoryHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repository-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'repo_id')->dropDownList($list,['prompt' => ''])?>

    <?= $form->field($model, 'commit') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'modified') ?>

    <?php // echo $form->field($model, 'added') ?>

    <?php // echo $form->field($model, 'removed') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
