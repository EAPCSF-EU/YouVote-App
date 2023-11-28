<div>

    <h2><?= Yii::t('main', 'Your password has been changed.') ?></h2>
    <p><?= Yii::t('main', 'Dear {name}, ', ['name' => $user->name]) ?></p>
    <p><?= Yii::t('main', 'This is a confirmation that your password has been changed. ') ?></p>
    <p><?= Yii::t('main', 'Your login is : {login}', ['login' => $user->username]) ?></p>
    <br>
    <p><?= Yii::t('main', 'Thank you!') ?></p>
</div>
