<style type="text/css">
.step {
    display: none;
}
.step-1 {
    display: block;
}
.wiz-finish-nav, .wiz-prev-nav {
    display: none;
}

.my_friend_selected  {
    display: none;
}
</style>

<form action="#" class="form-horizontal"  role="form" id="frmInviteMyFriends" method="post">
   <input type="hidden" id="business_id" name="business_id"  value="<?php echo $business_id; ?>" /><br/>


   <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Invite My Friends</h4>

            </div>
            <div class="modal-body">

                <div class="te">
                    <div class="row" style="height:600px;overflow:auto;">

                        <div class=col-lg-12>
                              <div class="row">

                                    <div class="step step-1">
                                    <?php foreach ($myLocalFriends as $myFriend) { ?>
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

                                            </div>
                                        </div>
                                    <?php } ?>

                                    </div>
                                    <div class="step step-2">

                                        <fieldset>
                                            <legend>Arrange a Meetup with my Friends</legend>
                                            <div class="form-group">
                                                <label for="meeting_date_time" class="col-md-2 control-label">DateTime Picking</label>
                                                <div class="input-group date form_datetime col-md-5" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="meeting_date_time">
                                                    <input size="16" type="text" value="" readonly class="form_datetime">
                                                </div>
                                				<input type="text" id="meeting_date_time" name="meeting_date_time"  value="" /><br/>
                                            </div>

                                            <div class="form-group">
                                                <label for="message" class="col-md-2 control-label">Send a message</label>
                                                <div class="input-group col-md-5">
                                                    <textarea rows="10" cols="45" id="mymessage" name="my_message"></textarea>
                                                </div>
                                            </div>

                                        </fieldset>
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

                              </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary wiz-prev-nav pull-left">Previous</button>
            <button type="button" class="btn btn-primary wiz-next-nav  pull-left">Next</button>
            <button type="button" class="btn btn-default wiz-close-nav " data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary wiz-finish-nav">Send invitation</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>



