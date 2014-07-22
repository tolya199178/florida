<style type="text/css">
#packages {
    background:#fff;
}

#packages .package {
    margin: 10px;
    padding: 5px;
}

#packages .package-select {
    position: absolute;
    top: 5px;
    left: 5px;
}

#packages .unselected {
    border: 1px solid #555555;
}

#packages .selected {
    border: 1px solid #ff0000;
}

#packages .buttons {
    text-align: center;
}

#packages .package .package-content {
    display: table;
}

#packages .thumbnail {
    display: table-cell;
    width: 150px;
    border: none;
}

#packages .description {
    display: table-cell;
    vertical-align: top;
}
</style>

<div id="packages">
    <form action="<?php echo $paypalUrl?>" method="post" id="paypal-form">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="currency_code" value="<?php echo CHtml::encode($paypalCurrency); ?>">
        <input type="hidden" name="business" value="<?php echo CHtml::encode($paypalAccount); ?>">

        <?php 
            $itemNumber = 1;
            $totalCost = 0;
            foreach($packageList as $package) {
        ?>
        <input type="hidden" name="item_name_<?php echo $itemNumber?>" value="<?php echo CHtml::encode($package->package_name)?>">
        <input type="hidden" name="item_number_<?php echo $itemNumber?>" value="<?php echo CHtml::encode($package->package_id)?>">
        <input type="hidden" name="quantity_<?php echo $itemNumber?>" value="1">
        <input type="hidden" name="amount_<?php echo $itemNumber?>" value="<?php echo CHtml::encode($package->package_price); ?>">
        <input type="hidden" name="tax_<?php echo $itemNumber?>" value="<?php echo CHtml::encode($tax); ?>">

        <?php
                $itemNumber++;
                $totalCost += $package->package_price;
            }

        ?>
        <!--<input type="hidden" name="mc_gross_">-->
        <input type="hidden" name="notify_url" value="<?php echo CHtml::encode($paypalNotifyUrl); ?>">
        <input type="hidden" name="return" value="<?php echo CHtml::encode($paypalReturnUrl); ?>">
        <input type="hidden" name="custom" value="<?php echo $business['business_id']?>" id="paypal-custom-field">
        <input type="hidden" name="no_shipping" value="1">
        
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Buy Packages</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    Confirm your purchase<br>
                    Business: <?php echo CHtml::encode($business->business_name)?><br>
                    Total Cost: $<?php echo $totalCost ?>
                </div>
            </div>
            
            <div class="container" id="package_listing_container">
                <?php 
                    foreach ($packageList as $package) {
                        $this->renderPartial('package-item', array('package' => $package, 'selectable' => false));
                    }
                ?>
            </div>

            <div class="row">
                <div class="col-sm-12 buttons">
                    <a href="#" id="buy-button"><img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Checkout with PayPal"></a>
                </div>
            </div>
        </div>
    </form>
</div>


<?php

$baseUrl = $this->createAbsoluteUrl('/');

$purchaseUrl = $baseUrl.'/package/package/createpurchase';

$script = <<<EOD

// /////////////////////////////////////////////////////////////////////////////
// Buy Button
// /////////////////////////////////////////////////////////////////////////////

    $('#buy-button').click(function() {
        var data = $('#paypal-form').serialize();
        $.post('$purchaseUrl', data, function(e) {
            var res = $.parseJSON(e);
            if(res.success == 1) {
                $('#paypal-custom-field').val(res.packagePurchaseId);
                $('#paypal-form').submit();
            }
        });
        return false;
    });
        
EOD;

Yii::app()->clientScript->registerScript('biz_listing', $script, CClientScript::POS_READY);

?>