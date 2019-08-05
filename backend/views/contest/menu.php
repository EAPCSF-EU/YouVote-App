<?php
/**
 * Created by PhpStorm.
 * User: sarvar
 * Date: 4/4/19
 * Time: 10:49 AM
 */

use yii\helpers\Html;
use common\models\Project;
use common\models\Category;

?>

<div class="panel">
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li class="<?= ($this->context->action->id == 'view') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-list-alt"></i> '.Yii::t('main', Yii::t('main', 'Overview')), ['view', 'id' => $model->id]) ?>
            </li>
            <li class="<?= ($this->context->action->id == 'edit') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-edit"></i> '.Yii::t('main', Yii::t('main', 'Details')), ['edit', 'id' => $model->id]) ?>
            </li>
            <li class="<?= ($this->context->action->id == 'projects') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-exchange"></i> '.Yii::t('main', 'Projects'). ' <span class="badge">'.Project::find()->where(['contest_id'=>$model->id])->count().'</span>', ['projects', 'id' => $model->id]) ?>
            </li>
            <li class="<?= ($this->context->action->id == 'categories') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-sort-alpha-asc"></i> '.Yii::t('main', 'Criteria').' <span class="badge">'.Category::find()->where(['contest_id'=>$model->id])->count().'</span>', ['categories', 'id' => $model->id]) ?>
            </li>
            <li><hr></li>
            <li class="<?= ($this->context->action->id == 'results') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-file-text"></i> '.Yii::t('main', 'Results'), ['results', 'id' => $model->id]) ?>
            </li>
            <li><hr></li>
            <li>
                <?= Html::a('<i class="fa fa-trash"></i> '.Yii::t('main', 'Delete'), ['delete', 'id' => $model->id],
                    ['data' => [
                    'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                    'method' => 'POST',
                ]]) ?>
            </li>
        </ul>
    </div>
</div>
