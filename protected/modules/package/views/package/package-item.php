<div class="row package unselected">
    <div class="container">
        <div class="row package-content">
            <div class="thumbnail">
                <?php echo CHtml::image(Yii::app()->baseUrl . '/uploads/images/package/thumbnails/' . CHtml::encode($package->package_image), CHtml::encode($package->package_name), array('class'=>"product-img"));?>
            </div>
            <div class="description">
                    <h3><?php echo CHtml::encode($package->package_name) ?></h3>
                    <div>
                        Price: $<?php echo CHtml::encode($package->package_price)?>
                    </div>
                    <div>
                        Expire: <?php echo CHtml::encode($package->package_expire)?> months
                    </div>
                    <div>
                        <?php echo $package->package_description?>
                    </div>
                    <div>
                        <?php 

                            foreach($package->packageItems as $item) {
                                $quantity = $item->itemType->has_quantity ? ': ' . CHtml::encode($item->quantity) : '';
                        ?>
                        <div><?php echo $item->itemType->name . $quantity?></div>
                        <?php
                            }

                        ?>
                </div>
            </div>
        </div>
    </div>
    <?php if($selectable) {?>
        <div class="package-select">
            <input type="checkbox" name="package_id[]" value="<?php echo (int) $package->package_id?>" class="package-select-input">
        </div>
    <?php }?>
</div>