<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?>
		<?php echo $form->textField($model,'user_type',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'user_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
		<?php echo $form->error($model,'created_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_time'); ?>
		<?php echo $form->textField($model,'modified_time'); ?>
		<?php echo $form->error($model,'modified_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by'); ?>
		<?php echo $form->error($model,'modified_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activation_code'); ?>
		<?php echo $form->textField($model,'activation_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'activation_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activation_status'); ?>
		<?php echo $form->textField($model,'activation_status',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'activation_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activation_time'); ?>
		<?php echo $form->textField($model,'activation_time'); ?>
		<?php echo $form->error($model,'activation_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'facebook_id'); ?>
		<?php echo $form->textField($model,'facebook_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'facebook_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'facebook_name'); ?>
		<?php echo $form->textField($model,'facebook_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'facebook_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'registered_with_fb'); ?>
		<?php echo $form->textField($model,'registered_with_fb',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'registered_with_fb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'loggedin_with_fb'); ?>
		<?php echo $form->textField($model,'loggedin_with_fb',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'loggedin_with_fb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'login_status'); ?>
		<?php echo $form->textField($model,'login_status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'login_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_login'); ?>
		<?php echo $form->textField($model,'last_login'); ?>
		<?php echo $form->error($model,'last_login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile_number'); ?>
		<?php echo $form->textField($model,'mobile_number',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'mobile_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile_carrier_id'); ?>
		<?php echo $form->textField($model,'mobile_carrier_id'); ?>
		<?php echo $form->error($model,'mobile_carrier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'send_sms_notification'); ?>
		<?php echo $form->textField($model,'send_sms_notification',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'send_sms_notification'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php echo $form->textField($model,'date_of_birth'); ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hometown'); ?>
		<?php echo $form->textField($model,'hometown',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hometown'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'marital_status'); ?>
		<?php echo $form->textField($model,'marital_status',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'marital_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'places_want_to_visit'); ?>
		<?php echo $form->textField($model,'places_want_to_visit',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'places_want_to_visit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'my_info_permissions'); ?>
		<?php echo $form->textField($model,'my_info_permissions',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'my_info_permissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photos_permissions'); ?>
		<?php echo $form->textField($model,'photos_permissions',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'photos_permissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'friends_permissions'); ?>
		<?php echo $form->textField($model,'friends_permissions',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'friends_permissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'blogs_permissions'); ?>
		<?php echo $form->textField($model,'blogs_permissions',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'blogs_permissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'travel_options_permissions'); ?>
		<?php echo $form->textField($model,'travel_options_permissions',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'travel_options_permissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->