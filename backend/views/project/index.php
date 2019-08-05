<?php

use common\models\Contest;
use common\models\Project;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h2 class="box-title"><?= Html::encode($this->title) ?></h2>
    <div class="pull-right">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
    <div class="box box-solid">
        <div class="box-header with-border">
            <br>
            <div>
                <?= Html::a(Yii::t('main', '<i class="fa fa-plus fa-lg"></i> &ensp;' . Yii::t('main','Create project')), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'image',
                    'content' => function($data) {
                        /** @var $data Project */
                        return '<img src="'.$data->imageLink.'" alt="'.$data->title.'">';
                    },
                    'filter' => false
                ],
                [
                    'attribute' => 'id',
                    'contentOptions'=> ['style'=>'width: 30px;']
                ],
                [
                    'attribute' => 'contest_id',
                    'filter' => Contest::getAllModelsAsArray(),
                    'content' => function($data) {
                        /** @var $data Project */
                        return $data->contest->title;
                    }
                ],
                [
                    'attribute' => 'title_'.Yii::$app->language,
                    'label' => Yii::t('main','Title')
                ],
                [
                    'attribute' => 'created_at',
                    'content' => function($data) {
                        /** @var $data Project */
                        return $data->getDateTimeByFormat('created_at');
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'content' => function($data) {
                        /** @var $data Project */
                        return $data->getDateTimeByFormat('updated_at');
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        </div>
    </div>
</div>
