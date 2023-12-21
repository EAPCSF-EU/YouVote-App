<?php

use yii\helpers\Html;
use common\models\Project;
use common\models\Category;

?>

<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills  flex-column">
            <li class="nav-item">
                <?php
                $accountClass = ($this->context->action->id == 'account') ? 'active' : '';
                echo Html::a('<i class="fa fa-list-alt"></i> ' . Yii::t('main', Yii::t('main', 'Account settings')),
                    ['account'], ['class' => "nav-link $accountClass"]) ?>
            </li>
            <li class="nav-item">
                <?php
                $securityClass = ($this->context->action->id == 'security') ? 'active' : '';
                echo Html::a('<i class="fa fa-list-alt"></i> ' . Yii::t('main', Yii::t('main', 'Security')),
                    ['security'], ['class' => "nav-link $securityClass"]) ?>
            </li>
        </ul>
    </div>
</div>
