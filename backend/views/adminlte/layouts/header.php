<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?#= Html::a('<span class="logo-mini"></span><span class="logo-lg">' . Yii::t('main','iVote') . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <a href="" title="" class="logo">
        <span class="logo-mini">
            <i style="font-size:150%" class="fa fa-mobile" aria-hidden="true"></i>
        </span>
        <span class="logo-lg">Voting EAP</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- <span class='welcome-message'><?=Yii::t('main','<b>Voting</b> system management')?></span> -->
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="lang <?=Yii::$app->language == 'en' ? 'active-lang' : ''?>">
                  <?= Html::a('en', ['/site/lang?lang=en']); ?>
                </li>

                <li class="lang ru <?=Yii::$app->language == 'ru' ? 'active-lang' : ''?>">
                    <?= Html::a('ru', ['/site/lang?lang=ru']); ?>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?= Yii::$app->user->identity->avatar ?>" class="user-image" alt="User Image"/>
                      <span class="hidden-xs"><?=Yii::$app->user->identity->name?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Yii::$app->user->identity->avatar ?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?=Yii::$app->user->identity->username?>
                                <small><?= Yii::$app->user->identity->name ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?= Html::a(
                                    Yii::t('main','Logout'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
