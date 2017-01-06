<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Repositories';
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

    <p>
        <?= Html::a('Create Repository', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-hover'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'url_git:url',
            // 'description:ntext',
            'local_path',
            'branch',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
