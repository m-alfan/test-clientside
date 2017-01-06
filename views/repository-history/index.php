<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RepositoryHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Repository Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repository-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Modal::begin([
        'header' => 'Search',
        'toggleButton' => ['label' => 'Search', 'class' => 'btn btn-default pull-right'],
    ]);

        echo $this->render('_search', ['model' => $searchModel, 'list' => $list]); 

    Modal::end();?>

    <p>
        <?= Html::a('Create Repository History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-hover'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'repo_id',
                'value' => 'repo.name',
            ],
            'commit',
            'author',
            // 'modified:ntext',
            // 'added:ntext',
            // 'removed:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
