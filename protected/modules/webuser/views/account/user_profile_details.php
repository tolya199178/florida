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
            <?php echo $form->labelEx($model,'language',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'language',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'language'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'mobile_carrier_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model, 'mobile_carrier_id', CHtml::listData(MobileCarrier::model()->findAll(),'mobile_carrier_id','mobile_carrier_name'), array('prompt'=>'Select the mobile carrier', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'mobile_carrier_id'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'mobile_number',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'mobile_number',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'mobile_number'); ?>
            </div>
        </div>
	</div>

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