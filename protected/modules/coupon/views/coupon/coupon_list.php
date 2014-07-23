<?php

    // $myMessagesSummary  = $data['myMessagesSummary'];

?>

<style>
<!--
#inbox {
	background: #fff;
}
-->
</style>

<style>


.badge {
  padding: 1px 9px 2px;
  font-size: 12.025px;
  font-weight: bold;
  white-space: nowrap;
  color: #ffffff;
  background-color: #999999;
  -webkit-border-radius: 9px;
  -moz-border-radius: 9px;
  border-radius: 9px;
}
.badge:hover {
  color: #ffffff;
  text-decoration: none;
  cursor: pointer;
}
.badge-error {
  background-color: #b94a48;
}
.badge-error:hover {
  background-color: #953b39;
}
.badge-warning {
  background-color: #f89406;
}
.badge-warning:hover {
  background-color: #c67605;
}
.badge-success {
  background-color: #468847;
}
.badge-success:hover {
  background-color: #356635;
}
.badge-info {
  background-color: #3a87ad;
}
.badge-info:hover {
  background-color: #2d6987;
}
.badge-inverse {
  background-color: #333333;
}
.badge-inverse:hover {
  background-color: #1a1a1a;
}
</style>

<div id="inbox">

    <div class="container">

        <p>&nbsp;</p>

        <!-- Main message area -->
        <div class="row">

            <!-- Coupon Summary Data -->
            <div class="col-sm-3 col-md-2">

                    <ul class="list-group">
                        <li class="list-group-item text-muted">Business Coupon Summary</li>
                        <li class="list-group-item text-right">
                            <span class="pull-left"><strong>Coupons Created.</strong></span>
                            <?php echo $myCouponSummary['countAll']; ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left"><strong>Coupons Printed.</strong></span>
                            <?php echo $myCouponSummary['countPrinted']; ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left"><strong>Value of Coupons printed.</strong></span>
                            <?php echo $myCouponSummary['valuePrinted']; ?>
                        </li>
                        <li class="list-group-item text-center">
                            <a class="btn btn-md btn-warning" href="<?php echo Yii::app()->createUrl('coupon/coupon/'); ?>">
                                <i class="glyphicon glyphicon-plus-sign"></i>
                                Manage your Coupons
                            </a>
                        </li>
                    </ul>

            </div>
            <!--  ./Coupon Summary Data -->

            <!--  Coupon Lists -->
            <div class="col-sm-9 col-md-10">

            <h2>List of Coupons</h2>

                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('coupon/coupon/add'); ?>">
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
                //     		array(
                //     			'name' => 'email',
                //     			'type' => 'raw',
                //     			'value' => 'CHtml::link(CHtml::encode($data["email"]), "mailto:".CHtml::encode($data["email"]))',
                //     		),
                    	),
                    ));

                ?>
            </div>

        </div>
        <!-- ./Coupon area -->


    </div>


</div>




