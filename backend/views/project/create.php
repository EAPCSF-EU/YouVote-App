<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = Yii::t('main', 'Create Project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <div class="row">
        <div class="col-xs-12">
            <h2 class="box-title"><?= Html::encode($this->title) ?></h2>
            <div class="pull-right">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="box box-solid">
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
