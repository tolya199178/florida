<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'user_name',
		'email',
		'password',
		'first_name',
		'last_name',
		'user_type',
		'status',
		'created_time',
		'modified_time',
		'created_by',
		'modified_by',
		'activation_code',
		'activation_status',
		'activation_time',
		'facebook_id',
		'facebook_name',
		'registered_with_fb',
		'loggedin_with_fb',
		'login_status',
		'last_login',
		'mobile_number',
		'mobile_carrier_id',
		'send_sms_notification',
		'date_of_birth',
		'hometown',
		'marital_status',
		'places_want_to_visit',
		'my_info_permissions',
		'photos_permissions',
		'friends_permissions',
		'blogs_permissions',
		'travel_options_permissions',
		'image',
	),
)); ?>
