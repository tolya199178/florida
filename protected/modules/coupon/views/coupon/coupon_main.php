<?php

     $myCouponSummary  = $data['myCouponSummary'];

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
                    </ul>

            </div>
            <!--  ./Coupon Summary Data -->

            <!-- Coupon Main View area -->
            <div class="col-sm-9 col-md-10">

                 <?php $this->renderPartial($data['mainview'], array('data' => $data)); ?>

            </div>

        </div>
        <!-- ./Coupon Main View area -->


    </div>


</div>




