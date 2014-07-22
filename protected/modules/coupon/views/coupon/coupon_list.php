<?php
    $this->widget('zii.widgets.grid.CGridView', array(
    	'dataProvider' => $arrayDataProvider,
    	'columns' => array(
    		array(
    			'name' => 'coupon_name',
    			'type' => 'raw',
    			'value' => 'CHtml::encode($data["coupon_name"])'
    		),
    	    array(
    	        'name' => 'number_of_uses',
    	        'type' => 'raw',
    	        'value' => 'CHtml::encode($data["number_of_uses"])'
    	    ),
    	    array(
    	        'name' => 'coupon_type',
    	        'type' => 'raw',
    	        'value' => 'CHtml::encode($data["coupon_type"])'
    	    ),
    	    array(
    	        'name' => 'coupon_expiry',
    	        'type' => 'raw',
    	        'value' => 'CHtml::encode($data["coupon_expiry"])'
    	    ),
    	    array(
    	        'name' => 'coupon_code',
    	        'type' => 'raw',
    	        'value' => 'CHtml::encode($data["coupon_code"])'
    	    ),
    	    array(
    	        'name' => 'printed',
    	        'type' => 'raw',
    	        'value' => 'CHtml::encode($data["printed"])'
    	    ),
    	    array(
    	        'name' => 'cost',
    	        'type' => 'raw',
    	        'value' => 'CHtml::encode($data["cost"])'
    	    ),
//     		array(
//     			'name' => 'email',
//     			'type' => 'raw',
//     			'value' => 'CHtml::link(CHtml::encode($data["email"]), "mailto:".CHtml::encode($data["email"]))',
//     		),
    	),
    ));

?>
