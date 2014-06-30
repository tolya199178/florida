<!--  Friend summary component -->

                        <ul class="list-group">
                            <li class="list-group-item text-muted">My Friends List <i
                                class="fa fa-dashboard fa-1x"></i></li>

                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>My Friends</strong>', Yii::app()->createUrl('/myfriend/myfriend/show/allfriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['allfriends'], Yii::app()->createUrl('/myfriend/myfriend/show/allfriends/')); ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>Friends Online</strong>', Yii::app()->createUrl('/myfriend/myfriend/show/onlinefriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['onlinefriends'], Yii::app()->createUrl('/myfriend/myfriend/show/onlinefriends/')); ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>Sent Friend Invitations</strong>', Yii::app()->createUrl('/myfriend/myfriend/show/onlinefriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['sentfriendrequests'], Yii::app()->createUrl('/myfriend/myfriend/show/sentfriendrequests/')); ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>Received Friend Invitations</strong>', Yii::app()->createUrl('/myfriend/myfriend/show/onlinefriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['receivedfriendrequests'], Yii::app()->createUrl('/myfriend/myfriend/show/receivedfriendrequests/')); ?>
                            </li>

                            <li class="list-group-item text-center">
                                <a class="btn btn-lg btn-success" href="<?php echo Yii::app()->createUrl('/myfriend/myfriend/show/allfriends/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Manage friends
                                </a>
                            </li>
                        </ul>