<!--           <div class="row"> -->

                <div class=col-lg-12>
                        <h1>My friends</h1>

                    <?php foreach ($myLocalFriends as $myFriend) { ?>
                    <?php
                            if ($myFriend->friend_status !='Approved') {
                                continue;
                            }

                    ?>
                    <div class='col-lg-4'>
                        <div class='myfriend' rel='<?php echo $myFriend->friend['user_id']; ?>'>
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

                            <input type="checkbox" class="my_friend_selected" id="my_friend_<?php echo $myFriend->friend['user_id']; ?>" name="invitation_list[]"  value="<?php echo $myFriend->friend['user_id']; ?>" />
                            <?php echo CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']); ?>
                            <br/><?php echo CHtml::encode($myFriend->friend['hometown']); ?>
                            <?php echo CHtml::link('See '.CHtml::encode($myFriend->friend['first_name']).'\'s profile', Yii::app()->createUrl('/webuser/profile/showfriend', array('friend' => $myFriend->friend['user_id'] )), array('class' => 'result_button_link'));   ?>


                        </div>
                    </div>
                <?php } ?>

                </div>

                <div class=col-lg-12>
                    <br/><br/>
                    <button>Send message</button>

                    <button>Block User</button>
                    <br/><br/>
                </div>

                <div class=col-lg-12>
                    <h1>Pending Friend Requests</h1>

                    <?php foreach ($myLocalFriends as $myFriend) { ?>
                    <?php
                            if ($myFriend->friend_status !='Pending') {
                                continue;
                            }
                    ?>
                    <div class='col-lg-4'>
                        <div class='myfriend' rel='<?php echo $myFriend->friend['user_id']; ?>'>
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

                            <?php echo CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']); ?>
                            <br/><?php echo CHtml::encode($myFriend->friend['hometown']); ?>

                            <?php echo CHtml::link('See '.CHtml::encode($myFriend->friend['first_name']).'\'s profile', Yii::app()->createUrl('/webuser/profile/showfriend', array('friend' => $myFriend->friend['user_id'] )), array('class' => 'result_button_link'));   ?>

                            <br/><br/>
                            <button>Accept</button>
                            <button>Reject</button>
                            <br/><br/>


                        </div>
                    </div>
                <?php } ?>
                </div>


                <?php foreach ($myOnlineFriends as $myFriend) { ?>
                    <div class='col-lg-4'>
                        <div class='myfriend'>
                            <?php
                                echo CHtml::image('https://graph.facebook.com/' . $myFriend["id"] . '/picture', "Image", array('width'=>50, 'height'=>50));
                            ?>
                            <?php echo CHtml::encode($myFriend['name']); ?>
                            <!-- <span class="label label-danger">< ? php echo CHtml::link('Send Message', Yii::app()->createUrl('/webuser/myolfriend/message', array('user_id' => Yii::app()->user->id, 'friend_id' => $myFriend["id"]  )), array('class' => 'result_button_link'));   ? ></span>   -->
                        </div>
                    </div>
                <?php } ?>

<!--           </div> -->