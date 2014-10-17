<?php

$myLocalFriends     = $data['listMyFriends']['lstMyFriends'];
$myOnlineFriends    = $data['listMyFriends']['lstMyOnlineFriends'];

?>

                        <div class="panel panel-default">


                            <div class="panel-heading">
                                Pending Friend Requests <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">


                                <ul class="list-group friend_list">


                                <?php foreach ($myLocalFriends as $myFriend) { ?>
                                <?php
                                        if ($myFriend->friend_status !='Pending') {
                                            continue;
                                        }
                                ?>
                                	<li>
                                	   <div class='col-lg-2'>

                                            <?php
//                                             if(@GetImageSize(Yii::getPathOfAlias('webroot').'/uploads/images/user/thumbnails/'.$myFriend->friend['image']))
//                                             {
                                                echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/user/thumbnails/'.$myFriend->friend['image'],
                                                                  CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name),
                                                                  array("width"=>"150px" ,"height"=>"150px") );
//                                             }
//                                             else
//                                             {
//                                                 echo CHtml::image(Yii::app()->theme->baseUrl .'/resources/images/site/no-image.jpg',
//                                                     CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']),
//                                                     array("width"=>"150px" ,"height"=>"150px") );
//                                             }
                                            ?>
                                	   </div>

                                	   <div class='col-lg-5'>
                                    		<h2><a href="#">
                                    		      <?php echo CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']); ?>
                                    		</a></h2>
                                    		<p><span><strong>Joined:</strong>&nbsp;</span><span><?php echo CHtml::encode($myFriend->friend['created_time']); ?><span></span></span></p>
                                    		<p><span><strong>Date of Birth:</strong>&nbsp;</span><span><?php echo CHtml::encode($myFriend->friend['date_of_birth']); ?><span></span></span></p>
                                    		<p><span><strong>Location:</strong>&nbsp;</span><span><?php echo CHtml::encode($myFriend->friend['hometown']); ?><span></span></span></p>
                                	   </div>

                                	   <div class='col-lg-5'>

                                            <a class="btn btn-md btn-danger" href="<?php echo Yii::app()->createUrl('myfriend/myfriend/unrequest/', array('friend'=>$myFriend->my_friend_id)); ?>">
                                                <i class="glyphicon glyphicon-minus-sign"></i>
                                                Cancel Invitation
                                            </a>

                                	   </div>
                                	</li>

                                <?php } ?>
                                </ul>

                            </div>

                        </div>