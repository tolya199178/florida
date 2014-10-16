<?php
/* @var $this ImportRestaurantCertificateFormController */
/* @var $model ImportRestaurantCertificateForm */
/* @var $form CActiveForm */
?>

<?php if($imported) {?>
        <?php echo CHtml::encode($importCount); ?> certificates imported
<?php }?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-restaurant-certificate-form-import-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'csvFile',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->fileField($model,'csvFile',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'csvFile'); ?>
	                </div>
	            </div>
	    	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->