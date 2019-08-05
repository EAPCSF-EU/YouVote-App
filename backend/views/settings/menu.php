<?php
use yii\helpers\Html;
use common\models\Project;
use common\models\Category;

?>

<div class="panel">
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li class="<?= ($this->context->action->id == 'account') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-list-alt"></i> '.Yii::t('main', Yii::t('main', 'Account settings')), ['account']) ?>
            </li>
            <li class="<?= ($this->context->action->id == 'security') ? 'active' : '' ?>">
                <?= Html::a('<i class="fa fa-list-alt"></i> '.Yii::t('main', Yii::t('main', 'Security')), ['security']) ?>
            </li>
        </ul>
    </div>
</div>
