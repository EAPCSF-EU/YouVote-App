<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Voter */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Voters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-sm-6">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
        </div>
    </div>
</section>
<div class="content">
    <div class="container-fluid bg-white p-4 border">
        <div class="row">
            <div class="col-12">
                <?= Html::a(Yii::t('main', '<i class="fa fa-pen fa-lg"></i> &ensp;' . Yii::t('main', 'Update')), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('main', '<i class="fa fa-trash fa-lg"></i> &ensp;' . Yii::t('main', 'Delete')), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <br>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'name',
                        [
                            'attribute' => 'project_id',
                            'value' => isset($model->projects[0]) ? $model->projects[0]->title : ''
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
</div>
