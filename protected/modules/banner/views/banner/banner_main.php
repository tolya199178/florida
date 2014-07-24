<?php

     $myBannerSummary  = $data['myBannerSummary'];

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

            <!-- Banner Summary Data -->
            <div class="col-sm-3 col-md-2">

                <?php $this->renderPartial('application.modules.business.views.business.dashboard.components.banner_summary', array('myBannerSummary'=>$myBannerSummary)); ?>


            </div>
            <!--  ./Banner Summary Data -->

            <!-- Banner Main View area -->
            <div class="col-sm-9 col-md-10">

                 <?php $this->renderPartial($data['mainview'], array('data' => $data)); ?>

            </div>

        </div>
        <!-- ./Banner Main View area -->


    </div>


</div>




