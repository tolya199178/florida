<?php
/* @var $this QuestionnaireController */
/* @var $model Questionnaire */
/* @var $form CActiveForm */
?>

<style>

    .form-group {
        padding-top:10px;
        padding-bottom:10px;
    }
</style>

<div class="form">
    <h3>Update Advertisement : <?php echo CHtml::encode($model->title); ?></h3>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'questionnaire-details-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'title',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'title',array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Type title", "data-original-title"=>"Type title.")); ?>
                <?php echo $form->error($model,'title'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'question',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'question',array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Type question", "data-original-title"=>"Type question.")); ?>
                <?php echo $form->error($model,'question'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'question_type',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,
                    'question_type',
                    $model->listType(),
                    array('class'=>"form-control",
                        'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select type", "data-original-title"=>"Select type.")
                );?>
                <?php echo $form->error($model,'question_type'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'answer',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textArea($model,'answer',array('class'=>"form-control", 'rows' => 4, 'cols' => 300,
                      'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter Answer here ", "data-original-title"=>"Enter Answer here...")); ?>
                <?php echo $form->error($model,'answer'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'bussiness_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php
                     echo $form->dropDownList($model,'business_id', CHtml::listData(Business::model()->findAll(), 'business_id', 'business_name'), array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select business", "data-original-title"=>"Select business.")); ?>
                <?php echo $form->error($model,'bussiness_id'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'user_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php
                     echo $form->dropDownList($model,'user_id', CHtml::listData(User::model()->findAll(), 'user_id', 'user_name'), array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select user", "data-original-title"=>"Select user.")); ?>
                <?php echo $form->error($model,'user_id'); ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->