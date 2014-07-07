
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Recent Trips <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($myTrips as $itemTrip) { ?>
                                    <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/mytravel/mytravel/details', array('id' => $itemTrip->trip_id))?>"><?php echo CHtml::encode($itemTrip->trip_name); ?></a></li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-lg btn-success" href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/add/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Add a Trip
                                </a>
                            </div>
                        </div>
