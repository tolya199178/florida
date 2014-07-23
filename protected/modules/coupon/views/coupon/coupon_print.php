<style>
<!--
#coupon_print {
	background: #fff;
}
-->
</style>

<style>


.printed_coupon {
	width: 750px;
	padding: 10px;
	text-align: center;
	border: 3px dashed #ccc;


    background-color: white;
    height: 600px;
/*     width: 400px; */
    margin: 100px auto;
    border: 3px dashed #21303b;

    /*shadow*/
    -webkit-box-shadow: 10px 10px 10px #000;
    -moz-box-shadow: 10px 10px 10px #000;
    box-shadow: 10px 10px 10px #000;

    /*rounded corners*/
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;


	 }
</style>

<div id="coupon_print">

    <div class="container">

        <p>&nbsp;</p>

        <!-- Main message area -->
        <div class="row">

            <!-- Coupon Summary Data -->
            <div class="col-sm-12">

                <div class='printed_coupon'>
                        <div class="col-sm-12">
                            <h1>$ <?php echo $model->cost; ?> OFF</h1>
                        </div>
                        <div class="col-sm-12">
                            <h4><?php echo $model->coupon_name; ?></h4>
                        </div>
                        <div class="col-sm-12">
                            <?php echo $model->coupon_description; ?>
                        </div>

                        <div class="col-sm-12">
                            <?php echo $model->terms; ?>
                        </div>
                        <div class="col-sm-12">
                            Expires : <?php echo $model->coupon_expiry; ?>
                        </div>


                </div>

            </div>
            <!--  ./Coupon Summary Data -->

        </div>
        <!-- ./Coupon Main View area -->


    </div>


</div>




