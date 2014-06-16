                <div id='postanswer_form'>

<style>

/* .form-group { */
/*     padding-top:10px; */
/*     padding-bottom:10px; */
/* } */
</style>

        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'frmNewEvent',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'  => false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>
        </div>
    <?php } ?>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_title',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_title',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_title'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_description',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textArea($model,'event_description',array('class'=>"form-control", 'rows' => 4, 'cols' => 300)); ?>
                <?php echo $form->error($model,'event_description'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_type',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,
                                               'event_type',
                                               $model->listEventTypes(),
                                               array('prompt'=>'Select Event Type')
                );?>
                <?php echo $form->error($model,'event_type'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_start_date',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">

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
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_start_time',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_start_time'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_end_date',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">

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
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_end_time',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_end_time'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_address1',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textArea($model,'event_address1',array('class'=>"form-control", 'rows' => 4, 'cols' => 300)); ?>
                <?php echo $form->error($model,'event_address1'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_address2',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textArea($model,'event_address2',array('class'=>"form-control",  'rows' => 4, 'cols' => 300)); ?>
                <?php echo $form->error($model,'event_address2'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_street',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_street',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_street'); ?>
            </div>
        </div>
	</div>

	<!--  Add a city selection dropdown -->
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_city_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'event_city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name')); ?>
                <?php echo $form->error($model,'event_city_id'); ?>
                <!--  todo: styling for dropdown -->
            </div>
        </div>
	</div>


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_phone_no',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_phone_no',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_phone_no'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_latitude',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
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
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'event_show_map', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_show_map'); ?>
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

<?php if (!empty($model->event_photo)) { ?>
	<div class="row">
        <div class="form-group">
            <span class="col-sm-2 control-label">Current Image</span>
            <div class="col-sm-4">
                <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/business/thumbnails/'.$model->image,
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
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'event_category_id', CHtml::listData(EventCategory::model()->findAll(), 'category_id', 'category_name')); ?>
                <?php echo $form->error($model,'event_category_id'); ?>
                <!--  todo: styling for dropdown -->
            </div>
        </div>
	</div>


	<div class="row">
        <div class="form-group">
            <!--  TODO: This must only displays the current user's business's  -->
            TODO: Show only business belonging to user.<br/>
            <?php echo $form->labelEx($model,'event_business_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'event_business_id', CHtml::listData(Business::model()->findAll(), 'business_id', 'business_name')); ?>
                <?php echo $form->error($model,'event_business_id'); ?>
                <!--  todo: styling for dropdown -->
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_tag',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_tag',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_tag'); ?>
            </div>
        </div>
	</div>


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'cost',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'cost',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'cost'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'event_frequency',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'event_frequency',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'event_frequency'); ?>
            </div>
        </div>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Post your New Event', array('class'=>"btn btn-success")); ?>
	</div>

<?php $this->endWidget(); ?>




                </div><!-- postanswer_form -->