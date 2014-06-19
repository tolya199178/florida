<script type="text/javascript">
function changeUserType(userType)
{

   if (userType == 'user')
   {
       document.getElementById('user_profile').style.display="block";
       return false;
   }
   else
   {
       document.getElementById('user_profile').style.display="none";
       return false;
   }

}

</script>

<style>
.row > .form-group
{
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update User: <?php echo CHtml::encode($model->first_name).' '.CHtml::encode($model->last_name).' (ID:'.$model->user_id.')'; ?></h3>
    <!-- Nav tabs -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Manage User</a>
        </div>
        <div>
            <div class="navbar-form navbar-left" role="search">
                <div class="form-group">

                    <ul class="nav nav-tabs" id="myTab">
                      <li><a href="#account" data-toggle="tab" class="btn btn-primary">Account</a></li>
                      <li><a href="#contact" data-toggle="tab" class="btn btn-primary">Contact</a></li>
                      <li><a href="#settings" data-toggle="tab" class="btn btn-primary">Settings</a></li>
                      <li><a href="#profile" data-toggle="tab" class="btn btn-primary">Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'=>false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="alert alert-danger">
	<?php echo $form->errorSummary($model); ?>
	</div>


<!--
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-5">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
-->

    <?php echo $form->hiddenField($model,'user_id'); ?>

<!-- Tab panes -->
<div class="tab-content">

  <!--  User Account Tab -->
  <div class="tab-pane active" id="account">

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'email',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'email',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'email'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'user_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'user_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'user_name'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'password',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'password',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'password'); ?>
            </div>
        </div>
	</div>


	<!--  Add Access rights processing for user -->
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'user_type',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,
                                               'user_type',
                                               $model->listUserType(),
                                               array('prompt'=>'Select User Type',
                                                     'onchange'=>'return changeUserType(this.value)',
                                                     'class'=>"form-control"
                                                    )
                );?>
                <?php echo $form->error($model,'user_type'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'status', $model->listStatus(), array('prompt'=>'Select User Account Status', 'class'=>"form-control", 'class'=>"form-control"));?>
                <?php echo $form->error($model,'status'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'registered_with_fb',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'registered_with_fb', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Facebook Status', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'registered_with_fb'); ?>
            </div>
        </div>
	</div>

	<!--  Todo: hide the next 2 fields if registered_with_fb = 'N' -->
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'facebook_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'facebook_id',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'facebook_id'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'facebook_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'facebook_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'facebook_name'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'created_by',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo CHtml::textField('UserReadOnly[createdBy]', CHtml::encode($model->createdBy->user_name), array('class'=>"form-control", 'readonly' => 'readonly')); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'created_time',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'created_time',array('class'=>"form-control", 'readonly' => 'readonly')); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'modified_by',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo CHtml::textField('UserReadOnly[modifiedBy]', CHtml::encode($model->modifiedBy->user_name), array('class'=>"form-control", 'readonly' => 'readonly')); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'modified_time',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'modified_time',array('class'=>"form-control", 'readonly' => 'readonly')); ?>
            </div>
        </div>
	</div>



  </div>
  <!--  End User Account Tab -->

  <!--  User Contact Details Tab -->
  <div class="tab-pane" id="contact">

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
                <?php echo $form->dropDownList($model, 'marital_status', $model->listMaritalStatus(), array('prompt'=>'Select Marital Status', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'marital_status'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'fldUploadImage',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo CHtml::activeFileField($model,'fldUploadImage',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'fldUploadImage'); ?>
            </div>
        </div>
	</div>

<?php if (!empty($model->image)) { ?>
	<div class="row">
        <div class="form-group">
            <span class="col-sm-2 control-label">Current Image</span>
            <div class="col-sm-4">
                <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/user/thumbnails/'.$model->image,
                                            "Image",
                                            array('width'=>150, 'height'=>150))); ?>
                </div>
            </div>
        </div>
	</div>
<?php } ?>


  </div>
  <!--  End User Contact Tab -->

  <!--  User Settings Tab -->

  <div class="tab-pane" id="settings">

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'send_sms_notification',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'send_sms_notification', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Choose Option', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'send_sms_notification'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'activation_status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'activation_status', $model->listActivationStatus(), array('prompt'=>'Choose Status', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'activation_status'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'activation_code',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'activation_code',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'activation_code'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'activation_time',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'activation_time',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
                <?php echo $form->error($model,'activation_time'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'loggedin_with_fb',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'loggedin_with_fb',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
                <?php echo $form->error($model,'loggedin_with_fb'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'login_status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'login_status',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
                <?php echo $form->error($model,'login_status'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'last_login',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'last_login',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
                <?php echo $form->error($model,'last_login'); ?>
            </div>
        </div>
    </div>



  </div>
  <!--  End User Settings Tab -->


  <!--  User Profile Tab -->

  <div class="tab-pane" id="profile">

    <!-- profile settings for type user -->
    <div id='user_profile' style="display:block">

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'places_visited',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <div style="overflow:auto; height: 200px">
                        <?php echo $form->CheckBoxList($model,'places_visited', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name')); ?>
                    </div>
                    <?php echo $form->error($model,'places_visited'); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'places_want_to_visit',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <div style="overflow:auto; height: 200px">
                        <?php echo $form->CheckBoxList($model,'places_want_to_visit', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name')); ?>
                    </div>
                    <?php echo $form->error($model,'places_want_to_visit'); ?>
                </div>
            </div>
        </div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'my_info_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'my_info_permissions', $model->listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'my_info_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'photos_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'photos_permissions', $model->listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'photos_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'friends_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'friends_permissions', $model->listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'friends_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'blogs_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'blogs_permissions', $model->listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'blogs_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'travel_options_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'travel_options_permissions', $model->listPermissions(), array('prompt'=>'Select Premission Level', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'travel_options_permissions'); ?>
                </div>
            </div>
    	</div>

    </div>
    <!-- end profile settings for type user -->



  </div>
  <!--  End User Profile Tab -->

</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-default")); ?>
	</div>

<?php $this->endWidget(); ?>

<br/>
<br/>
<br/>

<!-- for modals
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

-->
</div>

