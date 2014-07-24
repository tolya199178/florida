<?php

    $arrayDataProvider  = $data['arrayDataProvider'];

?>


                <h2>List of Coupons</h2>

                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('banner/banner/add'); ?>">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                    Add a New Banner
                </a>

                <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                    	'dataProvider' => $arrayDataProvider,
                    	'columns' => array(
                    		array(
                    			'name' => 'banner_title',
                    			'type' => 'raw',
                    			'value' => 'CHtml::encode($data["banner_title"])'
                    		),
                    	    array(
                    	        'name' => 'banner_url',
                    	        'type' => 'raw',
                    	        'value' => 'CHtml::encode($data["banner_url"])'
                    	    ),
                    	    array(
                    	        'name' => 'banner_expiry',
                    	        'type' => 'raw',
                    	        'value' => 'CHtml::encode($data["banner_expiry"])'
                    	    ),
                    	    array(
                    	        'name' => 'banner_status',
                    	        'type' => 'raw',
                    	        'value' => 'CHtml::encode($data["banner_status"])'
                    	    ),
                    	    array(
                    	        'name' => 'banner_view_limit',
                    	        'type' => 'raw',
                    	        'value' => 'CHtml::encode($data["banner_view_limit"])'
                    	    ),
                            array(
                                'class'=>'CButtonColumn',
                                'template'=>'{update}{delete}',
                                'updateButtonUrl'=>'Yii::app()->createUrl("banner/banner/updatebanner", array("banner_id"=>$data["banner_id"]))',
                                'buttons'=>array(
                                    'print' => array(
                                        'label'=>'<span class="glyphicon glyphicon-print"></span>', // text label of the button
                                        'url'=>'Yii::app()->createUrl("banner/banner/print", array("banner_id"=>$data["banner_id"]))',
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