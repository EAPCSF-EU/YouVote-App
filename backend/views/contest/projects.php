<?php

use common\models\Project;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('main', 'Update Contest projects: {name}', [
    'name' => $model->title,
]);

$js = <<<JS
    var loading = $('.loading-2');
    var inputs = $('#project-inputs');
    $('#project-form').on('beforeSubmit',function() {
        var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length) 
            {
                return false;
            }
            inputs.hide();
            loading.show();
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    console.log(data);
                    if(data.success) {
                        var html = '<div class="contest-project-item">' +
	                                '<div class="pull-left"><p>'+data.title+'</p></div>' +
	                                '<div class="pull-right">' +
		                            '<a href="javascript:void(0);" onclick="return deleteProject($(this));" class="delete" data-id="'+data.id+'">' +
			                        '<i class="glyphicon glyphicon-trash"></i>' +
		                            '</a></div><div class="clearfix"></div></div>';
                        $('.contest-projects-list').append(html);
	                                   
                    } else {
                        alert('System error');
                    }
                    loading.hide();
                    inputs.show();
                    form.trigger('reset');
                },
                error: function(data) {
                  loading.hide();
                  inputs.show();
                  form.trigger('reset');
                } 
            });
            return false;
    });
    
JS;

$deleteProjectUrl = Yii::$app->urlManager->createAbsoluteUrl('/contest/delete-project/');

$js2 = <<<JS
function deleteProject(obj) {
      if(confirm($('#confirm-text').val())) {
          $.ajax({
            type: 'get',
            url: '$deleteProjectUrl/' + obj.attr('data-id'),
            success: function(data) {
              if(data.success) {
                obj.parent().parent().remove();   
              }
            } 
          });
      }
    }
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
$this->registerJs($js2, \yii\web\View::POS_BEGIN);
$projectModel = new Project();
?>

<div class="content">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <?php if ($new) { ?>
                    <?php } else { ?>
                        <div class="col-3">
                            <?= $this->render("menu", ['model' => $model]); ?>
                        </div>
                    <?php } ?>

                    <div class="col-8">
                        <div class="card card-light">
                            <div class="card-header">
                                <?php if ($new) { ?>
                                    <div class="d-flex justify-content-between bd-highlight pt-1">
                                        <div class="bd-highlight">
                                            <h3 class="box-title"><?= Yii::t('main', 'Projects') ?></h3>
                                        </div>
                                        <div class="bd-highlight">
                                            <h3 class="box-title"><?= Yii::t('main', 'Step 2 of 3') ?></h3>
                                        </div>
                                        <div class="bd-highlight">
                                            <a class="btn btn-primary"
                                               href="<?= Url::to(['update', 'id' => $model->id, 'new' => true]) ?>"><i
                                                        class="glyphicon glyphicon-chevron-left"></i>&ensp;<?= Yii::t('main', 'Back') ?>
                                            </a>
                                            <a class="btn btn-primary"
                                               href="<?= Url::to(['categories', 'id' => $model->id, 'new' => true]) ?>"><?= Yii::t('main', 'Save & Continue') ?>&ensp;<i
                                                        class="glyphicon glyphicon-chevron-right"></i></a>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?= Html::a('<i class="fa fa-chevron-left"></i> ' . Yii::t('main', 'Overview'), ['view', 'id' => $model->id],
                                        ['class' => 'btn btn-info']) ?>
                                <?php } ?>
                            </div>

                            <div class="card-body">
                                <?= $this->render('project_form', ['model' => $model, 'projectModel' => $projectModel]) ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="confirm-text" value="<?= Yii::t('main', 'Are you sure you want to delete this item?') ?>">
</div>