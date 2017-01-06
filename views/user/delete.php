<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Delete';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-delete">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Are you sure you want to delete ? Please fill out the following fields with <code><?=Yii::$app->user->identity->username?></code> to delete.</p>

    <?php $form = ActiveForm::begin([
        'id' => 'delete-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Delete my account', ['class' => 'btn btn-danger', 'name' => 'delete-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>