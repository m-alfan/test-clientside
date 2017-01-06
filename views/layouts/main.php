<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Test Programmer',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $itemMenus[] = ['label' => 'Home', 'url' => ['/site/index']];

    if(Yii::$app->user->isGuest) {
        $itemMenus[] = ['label' => 'Login', 'url' => ['/user/login']];
    } else {
        $itemMenus[] = ['label'  => 'Repository', 'url' => '#',
            'items'   => [
                ['label' => 'List Repository', 'url' => ['/repository/index']],
                ['label' => 'History Repository', 'url' => ['/repository-history/index']],
            ],
        ];
        $itemMenus[] = ['label'  => 'Rest API ('.Yii::$app->user->identity->username.')', 'url' => '#',
            'items'   => [
                ['label' => 'User', 'url' => ['/user/index']],
                ['label' => 'Change Account', 'url' => ['/user/change-account']],
                ['label' => 'Change Password', 'url' => ['/user/change-password']],
                ['label' => 'Delete Account', 'url' => ['/user/delete']],
                '<li class="divider"></li>',
                ['label' => 'Logout', 'url' => ['/user/logout']],
            ],
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $itemMenus
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
