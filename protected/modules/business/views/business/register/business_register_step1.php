        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_name',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_name',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_name'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_address1',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textArea($model,'business_address1',array('class'=>"form-control", 'rows' => 4, 'cols' => 300)); ?>
                        <?php echo $form->error($model,'business_address1'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_address2',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textArea($model,'business_address2',array('class'=>"form-control",  'rows' => 4, 'cols' => 300)); ?>
                        <?php echo $form->error($model,'business_address2'); ?>
                    </div>
                </div>
        	</div>

        	<!--  Add a city selection dropdown -->
        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_city_id',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,'business_city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name'), array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_city_id'); ?>
                        <!--  todo: styling for dropdown -->
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_zipcode',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_zipcode',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_zipcode'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_phone',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_phone',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_phone'); ?>
                    </div>
                </div>
        	</div>

       	    <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_email',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_email',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_email'); ?>
                    </div>
                </div>
        	</div>





        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_website',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_website',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_website'); ?>
                    </div>
                </div>
        	</div>



        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_phone_ext',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_phone_ext',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_phone_ext'); ?>
                    </div>
                </div>
        	</div>

