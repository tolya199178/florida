<?php
/* @var $this MobileCarrierController */
/* @var $model MobileCarrier */
/* @var $form CActiveForm */
?>

<div class="form">


    <h3>Update Event : <?php echo $model->mobile_carrier_name; ?></h3>
    <p>&nbsp;</p>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mobile-carrier-details-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>
        </div>
    <?php } ?>

    <?php echo $form->errorSummary($model); ?>

    <p>&nbsp;</p>

    <?php echo $form->hiddenField($model,'mobile_carrier_id'); ?>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'mobile_carrier_name',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'mobile_carrier_name',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'mobile_carrier_name'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'recipient_address',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'recipient_address',array('class'=>"form-control")); ?> (HINT: Use {number} eg. {number}@mymobile.com )
                        <?php echo $form->error($model,'recipient_address'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'can_send',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->error($model,'can_send'); ?>
                        <?php echo $form->checkBox($model,'can_send', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'notes',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textArea($model,'notes',array('class'=>"form-control", 'rows' => 4, 'cols' => 300)); ?>
                        <?php echo $form->error($model,'notes'); ?>
                    </div>
                </div>
            </div>

    <p>&nbsp;</p>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->