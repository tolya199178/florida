<?php

$listMyBusiness     = $data['listMyBusiness'];
// $myLocalFriends     = $data['myLocalFriends'];
// $myOnlineFriends    = $data['myOnlineFriends'];
$myFriendsCount     = $data['myFriendsCount'];
$myInboxCount       = $data['myMessagesCount'];

?>


                        <div class="container">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                                <li><a href="#preferences" data-toggle="tab">Preferences</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">TODO: Details...</div>
                                <div class="tab-pane" id="settings">TODO: Settings...</div>
                                <div class="tab-pane" id="preferences">TODO: Preferences...</div>
                            </div>
                        </div>

                        <p>&nbsp;</p>



                        <!--left col-->
                        <ul class="list-group">
                            <li class="list-group-item text-muted">Profile</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span>
                                2.13.2014</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Last
                                        seen</strong></span> Yesterday</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Real
                                        name</strong></span> Joseph Doe</li>
                        </ul>

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

                        <?php $this->renderPartial('components/friends', array('myFriendsCount'=>$myFriendsCount)) ?>

                        <?php $this->renderPartial('components/messages_summary', array('myInboxCount'=>$myInboxCount)) ?>

