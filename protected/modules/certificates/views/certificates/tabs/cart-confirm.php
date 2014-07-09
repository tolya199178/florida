<form action="<?php echo $paypalUrl?>" method="post">

    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="currency_code" value="<?php echo CHtml::encode($paypalCurrency); ?>">
    <input type="hidden" name="business" value="<?php echo CHtml::encode($paypalAccount); ?>">
    <input type="hidden" name="item_name_1" value="Restaurant.com certficates">
    <input type="hidden" name="item_number_1" value="0001">
    <input type="hidden" name="quantity_1" value="<?php echo CHtml::encode($certQuantity); ?>">
    <!--<input type="hidden" name="mc_gross_">-->
    <input type="hidden" name="amount_1" value="<?php echo CHtml::encode($certPrice); ?>">
    <input type="hidden" name="tax_1" value="<?php echo CHtml::encode($tax); ?>">
    <input type="hidden" name="notify_url" value="<?php echo CHtml::encode($paypalNotifyUrl); ?>">
    <input type="hidden" name="return" value="<?php echo CHtml::encode($paypalReturnUrl); ?>">
    <input type="hidden" name="custom" value="<?php echo CHtml::encode($business['business_id']); ?>">
    <input type="hidden" name="no_shipping" value="1">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                Confirm purchase of:
            </div>
        </div>

        <div class="row">
            <div class="col-sm-11">
                <?php echo CHtml::encode($certQuantity); ?> certificates assigned to <?php echo CHtml::encode($business['business_name']); ?> for U$<?php echo $certPrice?> each for a total of U$<?php echo $certQuantity * $certPrice?>.
            </div>
        </div>

        <div class="row">

            <div class="col-sm-1">
                <a href="#" class="btn btn-primary btn-xs" id="cancel-cart">cancel</a>
            </div>
            <div class="col-sm-11">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Checkout with PayPal">
            </div>
        </div>

        </div>
    </div>
</form>