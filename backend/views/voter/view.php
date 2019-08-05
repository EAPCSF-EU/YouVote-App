<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Voter */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Voters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="voter-view">

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
        <div class="box-header with-border">
            <br>
            <div>
                <?= Html::a(Yii::t('main', '<i class="fa fa-pencil fa-lg"></i> &ensp;' . Yii::t('main','Update')), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('main', '<i class="fa fa-trash fa-lg"></i> &ensp;' . Yii::t('main','Delete')), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="panel-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'name',
                    [
                        'attribute' => 'project_id',
                        'value' => isset($model->projects[0])?$model->projects[0]->title:''
                    ],
//                    'email:email',
//                    [
//                        'attribute' => 'created_at',
//                        'value' => date('Y-m-d H:i',$model->created_at)
//                    ],
//                    [
//                        'attribute' => 'updated_at',
//                        'value' => date('Y-m-d H:i',$model->updated_at)
//                    ],

                ],
            ]) ?>
        </div>
    </div>
</div>
