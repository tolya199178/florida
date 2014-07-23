<?php
/* @var $this CouponController */
/* @var $model Coupon */
/* @var $form CActiveForm */
?>

<?php

    $model              = $data['model'];

?>

<style>

.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update Coupon : <?php echo CHtml::encode($model->coupon_name); ?></h3>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'coupon-details-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>
        </div>
    <?php } ?>

    <?php echo $form->hiddenField($model,'coupon_id'); ?>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'coupon_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'coupon_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'coupon_name'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'count_created',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-2">
                <?php echo $form->textField($model,'count_created',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'count_created'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'count_available',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-2">
                <?php echo $form->textField($model,'count_available',array('class'=>"form-control", 'readonly' => 'readonly')); ?>
                <?php echo $form->error($model,'count_available'); ?>
            </div>
        </div>
	</div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'coupon_description',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textArea($model,'coupon_description',array('class'=>"form-control",  'rows' => 4, 'cols' => 300)); ?>
                <?php echo $form->error($model,'coupon_description'); ?>
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

<?php if (!empty($model->coupon_photo)) { ?>
	<div class="row">
        <div class="form-group">
            <span class="col-sm-2 control-label">Current Image</span>
            <div class="col-sm-4">
                <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/coupon/thumbnails/'.$model->coupon_photo,
                                            "Image",
                                            array('width'=>150, 'height'=>150))); ?>
                </div>
            </div>
        </div>
	</div>
<?php } ?>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'terms',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textArea($model,'terms',array('class'=>"form-control",  'rows' => 4, 'cols' => 300)); ?>
                <?php echo $form->error($model,'terms'); ?>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'business_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'business_id', CHtml::listData(Business::model()->findAll(), 'business_id', 'business_name'), array('class'=>"form-control")); ?>

                <?php echo $form->error($model,'business_id'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'created_by',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo CHtml::textField('UserReadOnly[createdBy]', ((!empty($model->createdBy->user_name))?CHtml::encode($model->createdBy->user_name):''), array('class'=>"form-control", 'readonly' => 'readonly')); ?>
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
                <?php echo CHtml::textField('UserReadOnly[modifiedBy]', ((!empty($model->modifiedBy->user_name))?CHtml::encode($model->modifiedBy->user_name):''), array('class'=>"form-control", 'readonly' => 'readonly')); ?>
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

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'coupon_expiry',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-2">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'coupon_expiry',
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
                <?php echo $form->error($model,'coupon_expiry'); ?>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'coupon_value',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-2">
                <?php echo $form->textField($model,'coupon_value',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'coupon_value'); ?>
            </div>
        </div>
	</div>
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'coupon_value_type',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-2">
                <?php echo $form->dropDownList($model, 'coupon_value_type', array('%' => '%', '$' => '$'), array('prompt'=>'Select Coupon Value Type', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'coupon_value_type'); ?>
            </div>
        </div>
	</div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'active',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-2">
                <?php echo $form->dropDownList($model, 'active', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Status', 'class'=>"form-control"));?>
                <?php echo $form->error($model,'active'); ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->