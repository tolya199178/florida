<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_id',
		'user_name',
		'email',
		'password',
		'first_name',
		'last_name',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
