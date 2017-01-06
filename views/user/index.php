<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repository-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Modal::begin([
        'header' => 'Search',
        'toggleButton' => ['label' => 'Search', 'class' => 'btn btn-default pull-right'],
    ]);

        echo $this->render('_search', ['model' => $searchModel]); 

    Modal::end();?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-hover'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email',
            'created_at',
            'updated_at',
        ],
    ]); ?>
</div>
