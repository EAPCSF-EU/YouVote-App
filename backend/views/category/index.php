<?php

use common\models\Contest;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

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
                <?= Html::a(Yii::t('main', '<i class="fa fa-plus fa-lg"></i> &ensp;' . Yii::t('main','Create category')), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'contentOptions'=> ['style'=>'width: 30px;']
                    ],
                    [
                        'attribute' => 'contest_id',
                        'filter' => Contest::getAllModelsAsArray(),
                        'content' => function($data) {
                            /** @var $data \common\models\Category */
                            return $data->contest->title;
                        }
                    ],
                    'title_ru',
                    'title_en',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
