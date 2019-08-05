<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandImage' => '/files/images/eastern.png',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-eap navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('main', 'EAPCIVILSOCIETY'), 'url' => 'http://eapcivilsociety.eu/', 'linkOptions' => ['target' => '_blank']],
        ['label' => Yii::t('main', 'IDEA BANK'), 'url' => 'http://ideas.eapcivilsociety.eu/', 'linkOptions' => ['target' => '_blank']],
        ['label' => Yii::t('main', 'FELLOWS'), 'url' => 'http://fellows.eapcivilsociety.eu/', 'linkOptions' => ['target' => '_blank']],
        ['label' => Yii::t('main', 'HACKATHONS'), 'url' => 'http://eapcivilsociety.eu/what-we-do/ict-tools-and-hackathons', 'linkOptions' => ['target' => '_blank']],
        ['label' => Yii::t('main', 'E-LEARNING'), 'url' => 'http://elearning.eapcivilsociety.eu/', 'linkOptions' => ['target' => '_blank']],

        ['label' => Html::img("/files/images/eap.png"), 'url' => ['/site/contact'], 'encode' => false, "options" => [
            "class" => "eap-link"
        ]],
    ];
    if (Yii::$app->user->isGuest) {

    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right top-menu'],
        'items' => $menuItems,
    ]);


    NavBar::end();
    ?>
    <nav class="navbar navbar-sub">
        <div class="container">
            <h1 class="pull-left"><?=Yii::t('main',"Eastern Partnership Civil Society Hackathon");?></h1>

            <ul class="pull-right" id="lang-menu">
                <li class="nav-item">
                    <a class="nav-link <?= Yii::$app->language == "en" ? "active" : "" ?>"
                       href="/site/lang?lang=en">EN</a> |
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= Yii::$app->language == "ru" ? "active" : "" ?>" href="/site/lang?lang=ru"
                       style="padding-left: 4px">Рус</a>
                </li>
            </ul>

        </div>
    </nav>

    <?php if (!Yii::$app->user->isGuest): ?>
        <nav class="navbar navbar-user">
            <div class="container">
                <!--                <button type="button" class="btn btn-default" aria-label="Left Align">-->
                <!--                    <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>-->
                <!--                </button>-->
                <div class="dropdown pull-left">
                    <a href="#" class="dropdown-toggle" style="display: block;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="true">
                        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                        <!--                        <span class="caret"></span>-->
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> <?= Yii::t('main', 'Home'); ?></a>
                        </li>
                        <li><a href="/site/logout"><i class="fa fa-sign-out"
                                                      aria-hidden="true"></i> <?= Yii::t('main', 'Logout'); ?></a></li>
                    </ul>
                </div>

                <div class="user-profile pull-left">
                    <span class="icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                    <span class="title"><?= Yii::$app->user->identity->name; ?></span>
                </div>

                <?php
                if ($this->context->voterProject) {
                    echo "<div class='user-profile pull-left'>
                    <span class='icon'><i class='fa fa-lightbulb-o' aria-hidden='true'></i></span>
                    <span class='title'>" . $this->context->voterProject->title . "</span></div>";
                }
                ?>

                <div class="pull-right">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="pull-left"><?= Html::img("/files/images/footer_logo.png") ?> </div>
            </div>
            <!--        <p class="pull-left">&copy; --><? //= Html::encode(Yii::$app->name) ?><!-- -->
            <? //= date('Y') ?><!--</p>-->

            <!--        <p class="pull-right">--><? //= Yii::powered() ?><!--</p>-->
            <div class="col-md-8 text-center" style="padding-top: 10px">
                <span style="">
                    <?=Yii::t('main','The project is funded by the European Union and implemented by the consortium led by GDSI Limited')?> .</span>

            </div>
            <div class="col-md-2">
                <div class="pull-right"><?= Html::img("/files/images/footer_logo_2.jpg") ?> </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
