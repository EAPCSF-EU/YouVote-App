<?php

use yii\helpers\Html;
use common\models\Project;
use common\models\Category;

?>

<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <?php
                $viewActiveClass = ($this->context->action->id == "view") ? "active" : "";
                echo Html::a('<i class="fa fa-list-alt"></i> ' . Yii::t('main', Yii::t('main', 'Overview')),
                    ['view', 'id' => $model->id], ['class' => "nav-link $viewActiveClass"])
                ?>
            </li>
            <li class="nav-item">
                <?php
                $detailsActiveClass = ($this->context->action->id == "edit") ? "active" : "";
                echo Html::a('<i class="fa fa-edit"></i> ' . Yii::t('main', Yii::t('main', 'Details')), ['edit', 'id' => $model->id],
                    ['class' => "nav-link $detailsActiveClass"])
                ?>
            </li>
            <li class="nav-item">
                <?php
                $projectsClass = ($this->context->action->id == 'projects') ? 'active' : '';
                echo Html::a('<i class="fa fa-project-diagram"></i> ' . Yii::t('main', 'Projects') . ' <span class="float-right badge badge-dark">' . Project::find()->where(['contest_id' => $model->id])->count() . '</span>', ['projects', 'id' => $model->id],
                    ['class' => "nav-link $projectsClass"])
                ?>
            </li>
            <li class="nav-item">
                <?php
                $criteriaClass = ($this->context->action->id == 'categories') ? 'active' : '';
                echo Html::a('<i class="fa fa-arrow-down"></i> ' . Yii::t('main', 'Criteria') . ' <span class="float-right badge badge-dark">' . Category::find()->where(['contest_id' => $model->id])->count() . '</span>',
                    ['categories', 'id' => $model->id], ['class' => "nav-link $criteriaClass"]) ?>
            </li>
            <li class="nav-item">
                <?php
                $resultsClass = ($this->context->action->id == 'results') ? 'active' : '';
                echo Html::a('<i class="fa fa-file"></i> ' . Yii::t('main', 'Results'), ['results', 'id' => $model->id],
                    ['class' => "nav-link $resultsClass"]) ?>
            </li>
            <li class="nav-item">
                <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('main', 'Delete'),
                    ['delete', 'id' => $model->id],
                    ['class' => 'nav-link',
                        'data' => [
                            'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                            'method' => 'POST',
                        ]]) ?>
            </li>
        </ul>
    </div>
</div>
