<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConfigAws */
/* @var $form ActiveForm */

$this->title = 'Setup config AWS';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-aws">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to setup config aws</p>

    <?php $form = ActiveForm::begin([
        'id' => 'aws-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'region')->textInput() ?>
        <?= $form->field($model, 'key')->textInput() ?>
        <?= $form->field($model, 'secret')->textInput() ?>
    
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'account-button']) ?>
            </div>
        </div>
        
    <?php ActiveForm::end(); ?>

</div><!-- site-aws -->
