        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="chooseTypeLabel">Create New Event</h4>
        </div>


        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'                    =>'frmNewEvent',
                'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
            	'enableAjaxValidation'  => true,
        )); ?>

        <div class="modal-body">

              <p class="note">
                    Fields with <span class="required">*</span> are required.
              </p>

              <?php if($model->hasErrors()) {  ?>
                <div class="alert alert-danger">
                	<?php echo $form->errorSummary($model); ?>
                </div>
              <?php } ?>


              <div id='create_event_form'>
                  <ul class="nav nav-tabs" id="tabContent">
                    <li class="active"><a href="#event" data-toggle="tab">Event</a></li>
                    <li><a href="#datetime" data-toggle="tab">Date and Times</a></li>
                    <li><a href="#address" data-toggle="tab">Address</a></li>
                    <li><a href="#details" data-toggle="tab">Details</a></li>
                  </ul>

                  <div class="tab-content">

                    <div class="tab-pane active" id="event">

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_title',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'event_title',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_title'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_description',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textArea($model,'event_description',array('class'=>"form-control", 'rows' => 4, 'cols' => 300)); ?>
                                    <?php echo $form->error($model,'event_description'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_status',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->dropDownList($model,
                                                                   'event_status',
                                                                   $model->listStatus(),
                                                                   array('prompt'=>'Select Event Status', 'class'=>"form-control")
                                    );?>
                                    <?php echo $form->error($model,'event_status'); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="datetime">
                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_start_date',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">

                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $model,
                                        'attribute' => 'event_start_date',
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
                                    <?php echo $form->error($model,'event_start_date'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_start_time',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->dropDownList($model,
                                                                   'event_start_time',
                                                                   $model->listEventStartEndTimes(),
                                                                   array('prompt'=>'Select Event Start Time', 'class'=>"form-control")
                                                     );
                                    ?>
                                    <?php echo $form->error($model,'event_start_time'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_end_date',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">

                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $model,
                                        'attribute' => 'event_end_date',
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
                                    <?php echo $form->error($model,'event_end_date'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_end_time',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->dropDownList($model,
                                                                   'event_end_time',
                                                                   $model->listEventStartEndTimes(),
                                                                   array('prompt'=>'Select Event End Time', 'class'=>"form-control")
                                                     );
                                    ?>
                                    <?php echo $form->error($model,'event_end_time'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_frequency',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'event_frequency',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_frequency'); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="address">
                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_address1',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textArea($model,'event_address1',array('class'=>"form-control", 'rows' => 4, 'cols' => 300)); ?>
                                    <?php echo $form->error($model,'event_address1'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_address2',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textArea($model,'event_address2',array('class'=>"form-control",  'rows' => 4, 'cols' => 300)); ?>
                                    <?php echo $form->error($model,'event_address2'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_street',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'event_street',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_street'); ?>
                                </div>
                            </div>
                        </div>

                        <!--  Add a city selection dropdown -->
                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_city_id',array('class'=>"col-sm-2 control-label", 'id'=>'event_city_id')); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->dropDownList($model,'event_city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name'), array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_city_id'); ?>
                                    <!--  todo: styling for dropdown -->
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_phone_no',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'event_phone_no',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_phone_no'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_latitude',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'event_latitude',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_latitude'); ?>
                                    <?php echo $form->textField($model,'event_longitude',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_longitude'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_show_map',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->checkBox($model,'event_show_map', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_show_map'); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="details">

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'fldUploadImage',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo CHtml::activeFileField($model,'fldUploadImage',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'fldUploadImage'); ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($model->event_photo)) { ?>
                    	<div class="row">
                            <div class="form-group">
                                <span class="col-sm-2 control-label">Current Image</span>
                                <div class="col-sm-10">
                                    <div
                                        style="border: 1px solid #066A75; padding: 3px; width: 150px; height: 150px;"
                                        id="left">
                                        <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/business/thumbnails/'.$model->event_photo,
                                                                "Image",
                                                                array('width'=>150, 'height'=>150))); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>


                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_category_id',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->dropDownList($model,'event_category_id', CHtml::listData(EventCategory::model()->findAll(), 'category_id', 'category_name')); ?>
                                    <?php echo $form->error($model,'event_category_id'); ?>
                                    <!--  todo: styling for dropdown -->
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group">
                                <!--  TODO: This must only displays the current user's business's  -->
                                TODO: Show only business belonging to user.<br />
                                <?php echo $form->labelEx($model,'event_business_id',array('class'=>"col-sm-2 control-label", 'id'=>'event_business_id')); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->dropDownList($model,'event_business_id', CHtml::listData(Business::model()->findAll(), 'business_id', 'business_name')); ?>
                                    <?php echo $form->error($model,'event_business_id'); ?>
                                    <!--  todo: styling for dropdown -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'event_tag',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'event_tag',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'event_tag'); ?>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'cost',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo $form->textField($model,'cost',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'cost'); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                  </div>

              </div>



        </div>
        <div class="modal-footer">
            <div class="row buttons">
        		<?php echo CHtml::submitButton('Save the Event', array('class'=>"btn btn-success")); ?>
        	</div>

            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

        <?php $this->endWidget(); ?>




