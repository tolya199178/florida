
    <div id='feedresult'>
            <?php foreach ($model as $myFriend) { ?>
                <div class="row">
                    <div class=col-lg-2>
                        <?php
                            echo CHtml::image($myFriend->friend->image, "Image", array('width'=>50, 'height'=>50));
                        ?>
                    </div>
                    <div class="col-lg-10">
                        <p>
                            <?php echo CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name); ?>
                        </p>
                        <p>
                            <span class="label label-danger"><?php echo CHtml::link('Send Message', Yii::app()->createUrl('/webuser/myfriend/message', array('user_id' => Yii::app()->user->id, 'friend_id' => $myFriend->friend->user_id  )), array('class' => 'result_button_link')); ?></span>
                        </p>
                    </div>
                </div>
                <hr/>
            <?php } ?>
    </div>

