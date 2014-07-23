<?php
/* @var $this CouponController */
/* @var $model Coupon */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'coupon-details-form',
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
	                <?php echo $form->labelEx($model,'business_id',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'business_id',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'business_id'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'coupon_name',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'coupon_name',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'coupon_name'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'count_available',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'count_available',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'count_available'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'count_created',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'count_created',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'count_created'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'coupon_photo',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'coupon_photo',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'coupon_photo'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'coupon_description',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'coupon_description',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'coupon_description'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'terms',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'terms',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'terms'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'coupon_expiry',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'coupon_expiry',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'coupon_expiry'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'coupon_value',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'coupon_value',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'coupon_value'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'coupon_value_type',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'coupon_value_type',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'coupon_value_type'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'printed',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'printed',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'printed'); ?>
	                </div>
	            </div>
	    	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->