

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