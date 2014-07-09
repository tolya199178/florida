<div class="container">
    <div class="row">
        <div class="col-xs-10">

        </div>
        <div class="col-xs-1">
            <select id="cert-business-select">
                <option value="0">All</option>
                <?php
                    foreach($businessList as $business) {
                ?>
                <option value="<?php echo $business->business_id?>"><?php echo CHtml::encode($business->business_name); ?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-1">
            <select id="cert-allocated-select">
                <option value="-1">All</option>
                <option value="0">Available</option>
                <option value="1">Allocated</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" id="cert-list-table">
        </div>
    </div>

</div>