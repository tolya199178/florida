<?php

$listEvents         = $data['listEvents'];

?>
                        <!-- Messagebox summary component -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Events <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($listEvents as $itemEvent) { ?>
                                    <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/calendar/calendar/details/', array('id' => $itemEvent->event_id))?>"><?php echo $itemEvent->event_title; ?></a></li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-lg btn-warning" href="<?php echo Yii::app()->createUrl('calendar/calendar/myevents/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Manage your events
                                </a>
                            </div>
                        </div>

                        <!-- ./Messagebox summary component -->
