<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use common\models\Contest;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Voter */
/* @var $form yii\widgets\ActiveForm */
$url = Yii::$app->urlManager->createUrl(['/project/get-by-contest']);

$js = <<<JS

$("#voter-contest_id").on("change", function(){
	var data = {contest_id:$(this).val()};

	$.ajax({
         type: "GET", 
         url: '$url',
         // dataType: 'json',
         data: data,
         // async: true,
         success: function (response) {
            console.log(response);
             if(response !== ''){
                 // var json_obj = jQuery.parseJSON(JSON.stringify(response));
                 // console.log(json_obj);
                 // console.log("Success");
             	console.log(response);
	             	$("#voter-project_id").html(response);
                }
             }
       })

})

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

?>



<?php $form = ActiveForm::begin(); ?>

<?php #= $form->errorSummary($model); ?>


<div class="row">
    <div class="col-lg-4 col-md-4">
        <?php
        if ($model->isNewRecord)
            echo $form->field($model, 'email')->textInput(['maxlength' => true]);
        else
            echo "<p><h4>E-mail: " . $model->email . "</h4><hr></p>";
        ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
</div>


<div class="row">
    <div class="col-lg-4 col-md-4">
        <?php
        if ($model->project_id && $model->projects)
            $model->contest_id = $model->projects[0]->contest_id;

        echo $form->field($model, 'contest_id')->dropDownList(ArrayHelper::map(Contest::find()->all(), 'id', 'title'), ['prompt' => '- ' . Yii::t('main', 'Choose the contest') . ' -']) ?>
    </div>
</div>

<?php

?>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <?php
        if ($model->project_id && $model->projects && $model->projects[0]->contest) {
            echo $form->field($model, 'project_id')->dropDownList(ArrayHelper::map($model->projects[0]->contest->projects, 'id', 'title'), ['prompt' => '- ' . Yii::t('main', 'Choose the project') . ' -']);
        } else {
            echo $form->field($model, 'project_id')->dropDownList([], ['prompt' => "- " . Yii::t('main', 'Choose the project') . " -"]);
        }
        ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(Yii::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    <?php
    echo Html::a(Yii::t('main', 'Back'), ["index"], ['class' => 'btn btn-primary']);
    ?>
</div>

<?php ActiveForm::end(); ?>
