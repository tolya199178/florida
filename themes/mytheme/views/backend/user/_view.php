<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_type')); ?>:</b>
	<?php echo CHtml::encode($data->user_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
	<?php echo CHtml::encode($data->modified_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_code')); ?>:</b>
	<?php echo CHtml::encode($data->activation_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_status')); ?>:</b>
	<?php echo CHtml::encode($data->activation_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_time')); ?>:</b>
	<?php echo CHtml::encode($data->activation_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facebook_id')); ?>:</b>
	<?php echo CHtml::encode($data->facebook_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facebook_name')); ?>:</b>
	<?php echo CHtml::encode($data->facebook_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registered_with_fb')); ?>:</b>
	<?php echo CHtml::encode($data->registered_with_fb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loggedin_with_fb')); ?>:</b>
	<?php echo CHtml::encode($data->loggedin_with_fb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_status')); ?>:</b>
	<?php echo CHtml::encode($data->login_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_login')); ?>:</b>
	<?php echo CHtml::encode($data->last_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_number')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_carrier_id')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_carrier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_sms_notification')); ?>:</b>
	<?php echo CHtml::encode($data->send_sms_notification); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_birth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hometown')); ?>:</b>
	<?php echo CHtml::encode($data->hometown); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('marital_status')); ?>:</b>
	<?php echo CHtml::encode($data->marital_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('places_want_to_visit')); ?>:</b>
	<?php echo CHtml::encode($data->places_want_to_visit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('my_info_permissions')); ?>:</b>
	<?php echo CHtml::encode($data->my_info_permissions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photos_permissions')); ?>:</b>
	<?php echo CHtml::encode($data->photos_permissions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('friends_permissions')); ?>:</b>
	<?php echo CHtml::encode($data->friends_permissions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blogs_permissions')); ?>:</b>
	<?php echo CHtml::encode($data->blogs_permissions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('travel_options_permissions')); ?>:</b>
	<?php echo CHtml::encode($data->travel_options_permissions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	*/ ?>

</div>