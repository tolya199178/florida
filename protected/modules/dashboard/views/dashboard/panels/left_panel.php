<?php

$listMyBusiness     = $data['listMyBusiness'];
$myFriendsCount     = $data['myFriendsCount'];
$myInboxCount       = $data['myMessagesCount'];

?>

                        <!--left col-->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Businesses <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($listMyBusiness as $itemBusiness) { ?>
                                    <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/business/profile/', array('id' => $itemBusiness->business_id))?>"><?php echo $itemBusiness->business_name; ?></a></li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-lg btn-success" href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Add a business
                                </a>
                            </div>
                        </div>

                        <?php $this->renderPartial('components/friends_summary', array('myFriendsCount'=>$myFriendsCount)) ?>

                        <?php $this->renderPartial('components/messages_summary', array('myInboxCount'=>$myInboxCount)) ?>

                        <?php $this->renderPartial('components/events_top5', array('data'=>$data)) ?>

                        <?php $this->renderPartial('components/trip_list', array('data'=>$data)) ?>
