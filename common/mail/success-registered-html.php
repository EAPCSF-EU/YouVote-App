<?php
use common\components\App;

/** @var $voter \common\models\Voter */

?>

<div>
    <p></p>
    <p><?=Yii::t('main','You have successfully registered for Voting application of EaP Civil Society Hackathon. ',['appName' => Yii::$app->name])?></p>
    <p><?=Yii::t('main','Your login is : {login}',['login' => $voter->username])?></p>
    <p><?=Yii::t('main','Your password is : {password}',['password' => $voter->password])?></p>
    <p><?=Yii::t('main','URL to system: <a href="{url}">{url}</a>',['url' => App::getFrontend()])?></p>
    <br>
    <p><?=Yii::t('main','Thank you!')?></p>
</div>
