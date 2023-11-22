<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VoterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Voters');
$this->params['breadcrumbs'][] = $this->title;
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <?= Html::a(Yii::t('main', '<i class="fa fa-plus fa-lg"></i> &ensp;' . Yii::t('main', 'Create voter')), ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="card-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'attribute' => 'id',
                                    'contentOptions' => ['style' => 'width: 30px;']
                                ],
                                'name',
                                'email',
                                [
                                    'attribute' => 'project_id',
//                        'filter' => array("ID1"=>"Name1","ID2"=>"Name2"),
                                    'filter' => false,
                                    'content' => function ($data) {
                                        return (isset($data->projects[0])) ? $data->projects[0]->title : '';
                                    }
                                ],

//                    [
//                        'attribute' => 'created_at',
//                        'filter' => false,
//                        'content' => function($data) {
//                            /** @var $data \common\models\Voter */
//                            return date('Y-m-d H:i',$data->created_at);
//                        }
//                    ],
//                    [
//                        'attribute' => 'updated_at',
//                        'filter' => false,
//                        'content' => function($data) {
//                            /** @var $data \common\models\Voter */
//                            return date('Y-m-d H:i',$data->updated_at);
//                        }
//                    ],
                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

