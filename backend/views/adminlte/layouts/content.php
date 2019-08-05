<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
$controllerNames = Yii::$app->controller->id;
$js = <<<JS
    controllerName = '$controllerNames';
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);
?>
<div class="content-wrapper">
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong><?=Yii::t('main','Copyright &copy; {date} <a href="https://www.facebook.com/" target="_blank"> S&D </a>.</strong> All rightsreserved.',['date' => date('Y')])?>
</footer>

