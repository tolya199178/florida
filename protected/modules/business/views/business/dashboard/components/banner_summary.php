<?php

$listbanners         = $myBannerSummary;

?>
                        <!-- Messagebox summary component -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Banners<i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($listbanners as $itemBanner) { ?>
                                    <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/banner/banner/details/', array('id' => $itemBanner['banner_id']))?>"><?php echo CHtml::encode($itemBanner['banner_title']); ?></a></li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-lg btn-warning" href="<?php echo Yii::app()->createUrl('banner/banner/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Manage your banners
                                </a>
                            </div>
                        </div>

                        <!-- ./Messagebox summary component -->
