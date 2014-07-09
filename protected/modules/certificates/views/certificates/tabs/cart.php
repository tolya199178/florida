<div class="container" id="cart-form-container">
    <form id="cart-form">
        <div class="row">
            <div class="col-sm-1">
                Business:
            </div>
            <div class="col-sm-11">
                <select id="cert-business-select" name="business_id">
                    <?php
                        foreach($businessList as $business) {
                    ?>
                    <option value="<?php echo (int) $business->business_id; ?>"><?php echo CHtml::encode($business->business_name); ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row" id="cert-quantity">
            <div class="col-sm-1">
                Quantity:
            </div>
            <div class="col-sm-11">
                <input type="number" min="1" name="quantity" value="1">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-11">
                <a href="#" class="btn btn-primary btn-xs" id="cart-continue">continue</a>
            </div>
        </div>
    </form>
    <div id="cart-error-message"></div>
</div>

<div id="cart-confirm-container">

</div>