<?php
 $script = <<<EOD

            $(document).on('click','#preview_profile_page', function(event){

                // Get the view settings value
                var settings = { my_info_permissions        : $("#ProfileForm_my_info_permissions"),
                                 photos_permissions         : $("#ProfileForm_photos_permissions"),
                                 friends_permissions        : $("#ProfileForm_friends_permissions"),
                                 blogs_permissions          : $("#ProfileForm_blogs_permissions"),
                                 travel_options_permissions : $("#ProfileForm_travel_options_permissions")
                               }

                event.preventDefault();

                 var url         = $(this).attr('href');

         		// process the form. Note that there is no data send as posts arguements.
         		$.ajax({
         			type 		: 'POST',
         			url 		: url,
         		    data 		: settings,
         			dataType 	: 'json'
         		})
         		// using the done promise callback
         		.done(function(data) {

                     if (data.result == false)
                     {
                         return false;
                     }

                     $('#'+target).html(data.votes);


         		});

                return false;


           });

EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>
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
                    <?php echo $form->dropDownList($model, 'my_info_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
                    <?php echo $form->error($model,'my_info_permissions'); ?>
                </div>
            </div>
    	</div>

    	<div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'photos_permissions',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'photos_permissions', User::listPermissions(), array('prompt'=>'Select Premission Level'));?>
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
                &nbsp;
                <div class="col-sm-4">
                    <a href="<?php echo Yii::app()->createUrl('webuser/account/previewprofile'); ?>" id='preview_profile_page'>Show Preview</a>
                </div>
            </div>
    	</div>


        <!-- end profile settings for type user -->