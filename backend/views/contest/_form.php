<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Contest */
/* @var $form yii\widgets\ActiveForm */
/* @var $new integer */

if (!$model->isNewRecord) {
    $js = <<<JS
    $('img.thumbnail').attr('src',$('#image-value').val()); 
JS;

    $this->registerJs($js, \yii\web\View::POS_READY);
}

$js = <<<JS
    var start_date = $("#contest-start_date").val();
    var end_date = $("#contest-end_date").val();
    
    if(start_date){
        $("#contest-start_date").val(convertToYMDHMS(changeToCurrentTimeZone(start_date)));
    }

    if(end_date){
        $("#contest-end_date").val(convertToYMDHMS(changeToCurrentTimeZone(end_date)));
    }
    
    $('#contest-form-submit').on('click',function() {
        $("#timezone_diff").val(timezone_offset_minutes);
        $('#contest-form').submit();
    });

    $('#contest-range').tooltip();
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>


<?php $form = ActiveForm::begin(['id' => 'contest-form']); ?>
    <input type="hidden" name="timezone_diff" id="timezone_diff">


    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'description_en')->textArea(['rows' => '4']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'description_ru')->textArea(['rows' => '4']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'start_date')->widget(DateTimePicker::class, [
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii',
                    'inline' => 'true',
                    'sideBySide' => 'true',
                    // 'startDate' => date('Y-m-d H:i', time())
                ],
                'options' => ['autocomplete' => 'off',]
            ]) ?>
        </div>
        <div class="col-6">

            <?= $form->field($model, 'end_date')->widget(DateTimePicker::className(), [
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii',//
                    'inline' => true,
                    // 'startDate' => date('Y-m-d H:i', time())
                ],
                'options' => ['autocomplete' => 'off', 'removeButton' => false]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div style="width: 120px; float:left; ">
                <?= $form->field($model, 'range')->textInput(['type' => 'number', "min" => "2", "max" => "100",
                    "data-placement" => "right",
                    "title" => Yii::t('main', 'Range is a scale from min=2 to max=100 to evaluate each project')]) ?>
            </div>
        </div>
    </div>

    <div class="col-12">
        <hr>
    </div>


    <div class="col-12">
        <?= $form->field($model, 'image')->widget(\budyaga\cropper\Widget::className(), [
            'uploadUrl' => Url::toRoute('/contest/uploadphoto'),
            'width' => Yii::$app->params['contest_image_width'],
            'height' => Yii::$app->params['contest_image_height'],
            'cropAreaWidth' => 300,
            'cropAreaHeight' => 300,
            'aspectRatio' => true,
            'maxSize' => 6291456,
            'noPhotoImage' => Yii::$app->urlManager->createAbsoluteUrl('/default/no_image.png')
        ]) ?>
    </div>

    <input type="hidden" value="<?= $new ?>" name="new"/>
    <input type="hidden" id="image-value" value="<?= $model->imageLink ?>"/>
<?php ActiveForm::end(); ?>