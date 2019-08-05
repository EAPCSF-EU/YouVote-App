<?php

use common\models\Contest;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */


if(!$model->isNewRecord) {
    $js = <<<JS
    $('img.thumbnail').attr('src',$('#image-value').val()); 
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
}
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <?= $form->field($model, 'contest_id')->dropDownList(Contest::getAllModelsAsArray()) ?>
            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'content_en')->textarea(['rows' => 3, 'style' => 'resize:none']) ?>
            <?= $form->field($model, 'content_ru')->textarea(['rows' => 3, 'style' => 'resize:none']) ?>
        </div>
        <div class="col-lg-6 col-md-6">
            <?= $form->field($model, 'image')->widget(\budyaga\cropper\Widget::className(),[
                'uploadUrl' => Url::toRoute('/project/uploadphoto'),
                'width' => Yii::$app->params['project_image_width'],
                'height' => Yii::$app->params['project_image_height'],
                'maxSize' => 6291456,
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <input type="hidden" id="image-value" value="<?=$model->imageLink?>">

</div>
