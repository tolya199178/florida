<?php

$viewStats = $data['viewsCount'];

?>

                         <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Page Views <i class="fa fa-link fa-1x"></i>
                                </div>
                                <div class="panel-body">
                                    <div class='page_views_count'><?php echo $viewStats['totalPageViews']; ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Banner Views <i class="fa fa-link fa-1x"></i>
                                </div>
                                <div class="panel-body">
                                    <div class='banner_views_count'><?php echo $viewStats['totalBannerViews']; ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Number of Reviews <i class="fa fa-link fa-1x"></i>
                                </div>
                                <div class="panel-body">
                                    <div class='banner_views_count'><?php echo $viewStats['totalReviews']; ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Coupons Printed <i class="fa fa-link fa-1x"></i>
                                </div>
                                <div class="panel-body">
                                    <div class='banner_views_count'>0</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--/tab-content-->