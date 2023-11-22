<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <!--            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>-->
            <a href="#" class="nav-link" data-toggle="push-menu" data-widget="pushmenu" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item lang <?= Yii::$app->language == 'en' ? 'active-lang' : '' ?>">
            <?= Html::a('en', ['/site/lang?lang=en'], ['class' => 'nav-link']); ?>
        </li>

        <li class="nav-item lang ru <?= Yii::$app->language == 'ru' ? 'active-lang' : '' ?>">
            <?= Html::a('ru', ['/site/lang?lang=ru'], ['class' => 'nav-link']); ?>
        </li>
        <li class="nav-item dropdown user user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?= Yii::$app->user->identity->avatar ?>" class="user-image" alt="User Image"/>
                <span class="hidden-xs"><?= Yii::$app->user->identity->name ?></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="<?= Yii::$app->user->identity->avatar ?>" class="img-circle"
                         alt="User Image"/>
                    <p>
                        <?= Yii::$app->user->identity->username ?>
                        <small><?= Yii::$app->user->identity->name ?></small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-right">
                        <?= Html::a(
                            Yii::t('main', 'Logout'),
                            ['/site/logout'],
                            ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                        ) ?>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</header>
