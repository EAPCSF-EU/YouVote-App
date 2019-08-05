<?php
/**
 * Created by PhpStorm.
 * User: Davron
 * Date: 3/22/2019
 * Time: 23:15
 */
use common\components\App;

/** @var $voter \common\models\Voter */

$url = App::getFrontend().'/site/confirm/'.$voter->confirm_token;
?>

<div>
    <p>Hi, </p>
    <p><?=Yii::t('main','Please confirm your email address by clicking on the link below.')?></p>
    <p><a href="<?=$url?>"><?=$url?></a> </p>
    <p><?=Yii::t('main','Best regards,')?><br>
    <?=Yii::t('main',"EaP Civil Society Hackathon's team!")?></p>
</div>
