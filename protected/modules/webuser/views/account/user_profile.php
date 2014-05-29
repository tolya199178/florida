<?php
//print_r($model);
//exit;
?>
<style>
#main {
	background-color: white;
	/* top: 66px; */
	margin-top: -36px;
	position: relative;
}
</style>

<style type="text/css">

.my_friend_selected  {
    display: none;
}
</style>

    <div class="container">
        <!--  start anel -->
        <div class="row">
            <br />
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-warning">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Manage Your profile
                        </h3>
                    </div>

                    <div class="panel-body">


    	<p class="note">Fields with <span class="required">*</span> are required.</p>






<ul class="nav nav-pills">
  <li class="active"><a href="#mydetails" data-toggle="tab">My Details</a></li>
  <li><a href="#myprofile" data-toggle="tab">My Public Profile</a></li>
  <li><a href="#myfriends" data-toggle="tab">My Friends</a></li>
  <li><a href="#mymessages" data-toggle="tab">My Messages</a></li>
  <li><a href="#myimages" data-toggle="tab">My Images</a></li>
  <li><a href="#myactivities" data-toggle="tab">My Activities</a></li>
</ul>

    <div id='content' class="tab-content">
      <div class="tab-pane active" id="mydetails">

        <?php
         $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'profile-form',
        	'enableAjaxValidation'=>true,
        	'enableClientValidation'=>false,
        	'clientOptions'=>array(
        		'validateOnSubmit'=>true,
        	),
        	'htmlOptions' => array('enctype' => 'multipart/form-data'),
        	'focus'=>array($model,'username'),
        ));

        ?>


    	<div class="alert alert-danger">
    	<?php echo $form->errorSummary($model); ?>
    	</div>


        <?php echo $form->hiddenField($model,'user_id'); ?>
        <ul>


  <!--  User Account Tab -->


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'email',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'email',array('class'=>"form-control", 'readonly' => 'readonly')); ?>
                <?php echo $form->error($model,'email'); ?>
            </div>
        </div>
	</div>

  <!--  End User Account Tab -->

  <!--  User Contact Details Tab -->

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'first_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'first_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'first_name'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'last_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'last_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'last_name'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'date_of_birth',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">

                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'date_of_birth',
                    'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'mm-dd-yy', // save to db format
                    'altField' => '#self_pointing_id',
                    'altFormat' => 'dd-mm-yy', // show to user format
                    ),
                    'htmlOptions' => array(
                        //'style' => 'height:20px;',
                        'class' =>"form-control"
                    ),
                ));
                ?>
                <?php echo $form->error($model,'date_of_birth'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'mobile_carrier_id',array('class'=>"col-sm-2 control-label")); ?>

            <div class="col-sm-2">
                <?php echo $form->dropDownList($model, 'mobile_carrier_id', CHtml::listData(MobileCarrier::model()->findAll(),'mobile_carrier_id','mobile_carrier_name'), array('prompt'=>'Select the mobile carrier', 'class'=>"form-control"));?>
            </div>

            <?php echo $form->labelEx($model,'mobile_number',array('class'=>"col-sm-2 control-label")); ?>


            <div class="col-sm-2">
                <?php echo $form->textField($model,'mobile_number',array('class'=>"form-control")); ?>

                <?php echo $form->error($model,'mobile_carrier_id'); ?>
                <?php echo $form->error($model,'mobile_number'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'hometown',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'hometown',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'hometown'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'marital_status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'marital_status', User::listMaritalStatus(), array('prompt'=>'Select Marital Status'));?>
                <?php echo $form->error($model,'marital_status'); ?>
            </div>
        </div>
	</div>

  <!--  End User Contact Tab -->

  <!--  User Settings Tab -->


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'send_sms_notification',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'send_sms_notification', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Choose Option'));?>
                <?php echo $form->error($model,'send_sms_notification'); ?>
            </div>
        </div>
	</div>



  <!--  End User Settings Tab -->


  <!--  User Profile Tab -->


    <!-- profile settings for type user -->
    <div id='user_profile' style="display:none">
    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'places_want_to_visit',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model,'places_want_to_visit',array('class'=>"form-control")); ?>
                    <?php echo $form->error($model,'places_want_to_visit'); ?>
                </div>
            </div>
        </div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'my_info_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'my_info_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
                    <?php echo $form->error($model,'my_info_permissions'); ?>
                </div>
            </div>
    	</div>


    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'my_info_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'my_info_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
                    <?php echo $form->error($model,'my_info_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'photos_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'photos_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>s
                    <?php echo $form->error($model,'photos_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'friends_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'friends_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
                    <?php echo $form->error($model,'friends_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'blogs_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'blogs_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
                    <?php echo $form->error($model,'blogs_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'travel_options_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'travel_options_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
                    <?php echo $form->error($model,'travel_options_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'picture',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model,'picture',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
                    <?php echo $form->error($model,'picture'); ?>
                </div>
            </div>
        </div>
        <!-- end profile settings for type user -->


    	<div class="row buttons">
            <?php echo CHtml::submitButton('Update your Account', array('class'=>"btn btn-default")); ?>
    	</div>

        <?php $this->endWidget(); ?>./


  </div>
  <!--  End User Profile Tab -->

        </ul>



      </div>
      <div class="tab-pane" id="myprofile">

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'places_want_to_visit',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'places_want_to_visit',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'places_want_to_visit'); ?>
                    </div>
                </div>
            </div>


        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'my_info_permissions',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model, 'my_info_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                        <?php echo $form->error($model,'my_info_permissions'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'photos_permissions',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model, 'photos_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                        <?php echo $form->error($model,'photos_permissions'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'friends_permissions',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model, 'friends_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                        <?php echo $form->error($model,'friends_permissions'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'blogs_permissions',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model, 'blogs_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                        <?php echo $form->error($model,'blogs_permissions'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'travel_options_permissions',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model, 'travel_options_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                        <?php echo $form->error($model,'travel_options_permissions'); ?>
                    </div>
                </div>
        	</div>

        <ul>

        </ul>
      </div>

      <!-- My friends tab -->
      <div class="tab-pane" id="myfriends">

          <div class="row">

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

          </div>
      </div>

      <!-- My messages tab -->
      <div class="tab-pane" id="mymessages">
        My messages

        <?php $this-> renderPartial('//message/list', array('myMessages' => $myMessages)); ?>

      </div>

      <!-- My images tab -->
      <div class="tab-pane" id="myimages">

        <?php $this->renderPartial('//user_photos/list', array('myPhotos' => $myPhotos)); ?>

        <?php $this->renderPartial('//user_photos/new_image'); ?>


      </div>

      <!-- My Reviews tab -->
      <div class="tab-pane" id="#myactivities">
            <?php $this->renderPartial('//user_activities/listall', array('myActivities' => $myActivities)); ?>
      </div>


    </div>
    <!--  End of tabs -->



                    </div>
                </div>
            </div>

        </div>
        <!--  end panel -->
    </div>

