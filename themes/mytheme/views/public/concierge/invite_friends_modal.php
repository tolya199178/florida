<style>

@import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);

.panel > .list-group .list-group-item:first-child {
    /*border-top: 1px solid rgb(204, 204, 204);*/
}

.c-search > .form-control {
   border-radius: 0px;
   border-width: 0px;
   border-bottom-width: 1px;
   font-size: 1.3em;
   padding: 12px 12px;
   height: 44px;
   outline: none !important;
}
.c-search > .form-control:focus {
    outline:0px !important;
    -webkit-appearance:none;
    box-shadow: none;
}
.c-search > .input-group-btn .btn {
   border-radius: 0px;
   border-width: 0px;
   border-left-width: 1px;
   border-bottom-width: 1px;
   height: 44px;
}


.c-list {
    padding: 0px;
    min-height: 44px;
}
.title {
    display: inline-block;
    font-size: 1.7em;
    font-weight: bold;
    padding: 5px 15px;
}
ul.c-controls {
    list-style: none;
    margin: 0px;
    min-height: 44px;
}

ul.c-controls li {
    margin-top: 8px;
    float: left;
}

ul.c-controls li a {
    font-size: 1.7em;
    padding: 11px 10px 6px;
}
ul.c-controls li a i {
    min-width: 24px;
    text-align: center;
}

ul.c-controls li a:hover {
    background-color: rgba(51, 51, 51, 0.2);
}

.c-toggle {
    font-size: 1.7em;
}

.name {
    font-size: 1.7em;
    font-weight: 700;
}

.c-info {
    padding: 5px 10px;
    font-size: 1.25em;
}

</style>


<style>
<!--
.headshot {
    width:100px;
    height:100px'
}

.my_friend_selected  {
    display: none;
}

#contact-list
{
  height:500px;
  overflow-y: auto;
}



-->
</style>

<form action="#" class="form-horizontal"  role="form" id="frmInviteMyFriends" method="post">
   <input type="hidden" id="business_id" name="business_id"  value="<?php echo (int) $modelBusiness->business_id; ?>" />

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Invite your Friends</h4>
      </div>
      <div class="modal-body">

            <div class="row">
                <div class="col-sm-6">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading c-list">
                                    <span class="title">Contacts</span>
                                    <ul class="pull-right c-controls">
                                        <li><a href="#cant-do-all-the-work-for-you" data-toggle="tooltip" data-placement="top" title="Add Contact"><i class="glyphicon glyphicon-plus"></i></a></li>
                                        <li><a href="#" class="hide-search" data-command="toggle-search" data-toggle="tooltip" data-placement="top" title="Toggle Search"><i class="fa fa-ellipsis-v"></i></a></li>
                                    </ul>
                                </div>

                                <div class="row" style="display: none;">
                                    <div class="col-xs-12">
                                        <div class="input-group c-search">
                                            <input type="text" class="form-control" id="contact-list-search">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search text-muted"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-group" id="contact-list">

                                    <?php foreach ($myLocalFriends as $myFriend) { ?>

                                    <li class="list-group-item myfriend" rel='<?php echo (int) $myFriend->friend['user_id']; ?>'>
                                        <div class="col-xs-12 col-sm-3">
                                            <img src="<?php echo Yii::app()->request->baseUrl.'/uploads/images/user/'.$myFriend->friend['image']; ?>" alt="Scott Stevens" class="img-responsive img-circle headshot" />
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <span class="name"><?php echo CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name); ?></span><br/>
                                            <span class="glyphicon glyphicon-map-marker text-muted c-info" data-toggle="tooltip" title="<?php echo CHtml::encode($myFriend->friend['hometown']); ?>"></span>
                                            <span class="visible-xs"> <span class="text-muted"><?php echo CHtml::encode($myFriend->friend['hometown']); ?></span><br/></span>
                                            <span class="glyphicon glyphicon-earphone text-muted c-info" data-toggle="tooltip" title="<?php echo CHtml::encode($myFriend->friend['mobile_number']); ?>"></span>
                                            <span class="visible-xs"> <span class="text-muted"><?php echo CHtml::encode($myFriend->friend['mobile_number']); ?></span><br/></span>
                                            <span class="fa fa-comments text-muted c-info" data-toggle="tooltip" title="<?php echo CHtml::encode($myFriend->friend['email']); ?>"></span>
                                            <span class="visible-xs"> <span class="text-muted">s<?php echo CHtml::encode($myFriend->friend['email']); ?></span><br/></span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input type="checkbox" class="my_friend_selected" id="my_friend_<?php echo (int) $myFriend->friend['user_id']; ?>" name="invitation_list[]"  value="<?php echo (int) $myFriend->friend['user_id']; ?>" />

                                    </li>
<?php                               } ?>
                                </ul>
                            </div>
                        </div>
                	</div>



                </div>
                <div class="col-sm-6">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span class="title">Send a Message</span>
                                </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Send an invitation to meet at :</p>
                                            <p><?php  echo CHtml::encode($modelBusiness->business_address1.
                                                           ' '.$modelBusiness->business_address2.
                                                           ' '.$modelBusiness->businessCity['city_name']
                                                           ); ?></p>
                                            <p>on <?php echo date("l jS F Y", time()); ?>

                                            <p>&nbsp;</p>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">

                                            <fieldset>
<!--                                                 <legend>Arrange a Meetup with my Friends</legend> -->
<!--                                                 <div class="form-group"> -->
<!--                                                     <label for="meeting_date_time" class="col-md-2 control-label">DateTime Picking</label> -->
<!--                                                     <div class="input-group date form_datetime col-md-5" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="meeting_date_time"> -->
<!--                                                         <input size="16" type="text" value="" readonly class="form_datetime"> -->
<!--                                                     </div> -->
<!--                                     				<input type="text" id="meeting_date_time" name="meeting_date_time"  value="" /><br/> -->
<!--                                                 </div> -->

                                                <div class="form-group">
                                                    <label for="meeting_date" class="col-md-4 control-label">Meeting Date</label>
                                                    <div class="input-group col-md-8">
                                                    <input type="text" id="meeting_date" name="meeting_date" value="" readonly='readonly'>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="meeting_time" class="col-md-4 control-label">Meeting Time</label>
                                                    <div class="input-group col-md-8">
                                                    <input type="text" id="meeting_date" name="meeting_date" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message" class="col-md-4 control-label">Send a message</label>
                                                    <div class="input-group col-md-8">
                                                        <textarea rows="8" cols="30" id="mymessage" name="my_message"></textarea>
                                                    </div>
                                                </div>

                                            </fieldset>
                                        </div>
                                    </div>



                            </div>
                        </div>
                	</div>

                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary wiz-finish-nav">Send invitation</button>

      </div>

</form>

