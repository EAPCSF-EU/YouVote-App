<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Contest */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contest-view">
    <br>
    <div class="row">
        <div class="col-sm-12">
            <div style="width: 230px; float: left;">
                <?= $this->render("menu", ['model' => $model]); ?>
            </div>

            <div class="col-sm-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= Html::a('<i class="fa fa-chevron-left"></i> ' .
                            Yii::t('main', 'Overview'), ['view', 'id'=>$model->id], ['class' => 'btn btn-info']) ?>

                        <?= Html::submitButton('<i class="fa fa-check"></i> '.Yii::t('main', 'Save'), [
                            'id' => 'contest-form-submit',
                            'class' => 'btn btn-primary pull-right']) ?>
                    </div>
                    <div class="panel-body">
                        <?= $this->render('_form', ['model' => $model, "new" => false]); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
