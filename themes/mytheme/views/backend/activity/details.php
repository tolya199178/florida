 <?php
/* @var $this ActivityController */
/* @var $model Activity */
/* @var $form CActiveForm */
?>
<style>

.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update Activity: <?php echo $model->keyword; ?></h3>
        
        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'activity-details-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'keyword',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'keyword',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'keyword'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'language',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                    <?php echo $form->dropDownList($model,'language', CHtml::listData(Language::model()->findAll(), 'short', 'name'), array('class' =>"form-control")); ?> 
                        
                        <?php echo $form->error($model,'language'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'related_words',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'related_words',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'related_words'); ?>
                    </div>
                </div>
            </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

