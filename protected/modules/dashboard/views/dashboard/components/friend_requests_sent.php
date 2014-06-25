<?php

$myLocalFriends     = $data['listMyFriends']['lstMyFriends'];
$myOnlineFriends    = $data['listMyFriends']['lstMyOnlineFriends'];

?>

                        <div class="panel panel-default">


                            <div class="panel-heading">
                                My Friends <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">


                                <ul class="list-group" id='friend_list' style="height:300px;overflow-y:auto;overflow-x:off;">

                                <?php foreach ($myLocalFriends as $myFriend) { ?>
                                <?php
                                        if ($myFriend->friend_status !='Pending') {
                                            continue;
                                        }
                                ?>
                                    <div class='row myfriend' rel='<?php echo CHtml::encode($myFriend->friend['user_id']); ?>' id="<?php echo strtolower($myFriend->friend['first_name']); ?>">
                                        <div class='col-lg-3'>

                                            <?php
                                            if(@GetImageSize(Yii::getPathOfAlias('webroot').'/uploads/images/user/thumbnails/'.$myFriend->friend['image']))
                                            {
                                                echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/user/thumbnails/'.$myFriend->friend['image'],
                                                                  CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name),
                                                                  array("width"=>"50px" ,"height"=>"50px") );
                                            }
                                            else
                                            {
                                                echo CHtml::image(Yii::app()->theme->baseUrl .'/resources/images/site/no-image.jpg',
                                                    CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']),
                                                    array("width"=>"50px" ,"height"=>"50px") );
                                            }
                                            ?>
                                        </div>
                                        <div class='col-lg-9'>
                                            <input type="checkbox" class="my_friend_selected" id="my_friend_<?php echo $myFriend->friend['user_id']; ?>" name="invitation_list[]"  value="<?php echo $myFriend->friend['user_id']; ?>" />
                                            <?php echo CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']); ?>
                                            <br/><?php echo CHtml::encode($myFriend->friend['hometown']); ?>
                                            <?php echo CHtml::link('See '.CHtml::encode($myFriend->friend['first_name']).'\'s profile', Yii::app()->createUrl('/webuser/profile/showfriend', array('friend' => $myFriend->friend['user_id'] )), array('class' => 'result_button_link'));   ?>
                                        </div>
                                    </div>

                                <?php } ?>
                                </ul>

                            </div>

                        </div>