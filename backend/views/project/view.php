<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

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
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'contest_id',
                                'value' => $model->contest->title
                            ],
                            'title_en',
                            'title_ru',
                            'content_en:ntext',
                            'content_ru:ntext',
                            [
                                'attribute' => 'created_at',
                                'value' => $model->getDateTimeByFormat('created_at')
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => $model->getDateTimeByFormat('updated_at')
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-4 image-view">
                    <img src="<?=$model->imageLink?>" alt="<?=$model->title?>">
                </div>
            </div>
        </div>
    </div>
</div>
