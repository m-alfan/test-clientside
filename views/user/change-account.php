<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-account">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to change your account</p>

    <?php $form = ActiveForm::begin([
        'id' => 'account-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <hr>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'account-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>