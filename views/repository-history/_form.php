<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RepositoryHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repository-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'repo_id')->dropDownList($list,['prompt' => ''])?>

    <?= $form->field($model, 'commit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modified')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'added')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'removed')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
