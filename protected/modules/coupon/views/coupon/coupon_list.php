<?php

    $arrayDataProvider  = $data['arrayDataProvider'];

?>


                <h2>List of Coupons</h2>

                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('coupon/coupon/createrequest'); ?>">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                    Add a New Coupon
                </a>

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
                            array(
                                'class'=>'CButtonColumn',
                                'template'=>'{update}{delete}{print}',
                                'updateButtonUrl'=>'Yii::app()->createUrl("coupon/coupon/updatecoupon", array("coupon_id"=>$data["coupon_id"]))',
                                'buttons'=>array(
                                    'print' => array(
                                        'label'=>'<span class="glyphicon glyphicon-print"></span>', // text label of the button
                                        'url'=>'Yii::app()->createUrl("coupon/coupon/print", array("coupon_id"=>$data["coupon_id"]))',
                                        // 'imageUrl'=>'/path/to/copy.gif',  // image URL of the button. If not set or false, a text link is used
                                        'options' => array('class'=>'copy'), // HTML options for the button
                                    ),
                                ),
                                                            "htmlOptions" => array(
                                    'style'=>'width: 60px;',
                                    'class' => 'action_class'
                                )
                            )
                    	),
                    ));

                ?>