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