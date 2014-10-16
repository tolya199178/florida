<?php
/* @var $this RestaurantCertificateController */
/* @var $model RestaurantCertificate */
/* @var $form CActiveForm */
?>

<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js', CClientScript::POS_END);


?>

<style>

.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Manage Certificate: <?php echo CHtml::encode($model->certificate_number); ?></h3>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'restaurant-certificate-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'certificate_number',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'certificate_number',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
	                    <?php echo $form->error($model,'certificate_number'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'purchase_amount',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'purchase_amount',array('class'=>"form-control", 'readonly'=>'readonly')); ?>
	                    <?php echo $form->error($model,'purchase_amount'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'availability_status',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
                        <?php
//                            $model->listAvailabilityStatus();
                            Echo $form->dropDownList(
                                $model,
                                'availability_status',
                                $model->listAvailabilityStatus(),
                                array('prompt'=>'Select Availability Status', 'class'=>"form-control")
                            );
                        ?>
	                    <?php echo $form->error($model,'availability_status'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'redeemer_email',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'redeemer_email',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'redeemer_email'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'purchase_date',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
                        <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'purchase_date',
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
	                    <?php echo $form->error($model,'purchase_date'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'purchased_by_business_date',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'purchased_by_business_date',
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
	                    <?php echo $form->error($model,'purchased_by_business_date'); ?>
	                </div>
	            </div>
	    	</div>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'business_id',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
                        <?php echo CHtml::hiddenField('RestaurantCertificate[business_id]', '', array ('id'=>'RestaurantCertificate_business_id')); ?>
	                    <?php echo $form->error($model,'business_id'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'redeemer_user_id',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
                        <?php echo CHtml::hiddenField('RestaurantCertificate[redeemer_user_id]', '', array ('id'=>'RestaurantCertificate_redeemer_user_id')); ?>

	                    <?php echo $form->error($model,'redeemer_user_id'); ?>
	                </div>
	            </div>
	    	</div>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'redeem_date',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'redeem_date',
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
	                    <?php echo $form->error($model,'redeem_date'); ?>
	                </div>
	            </div>
	    	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php

$userAutoCompleteURL = Yii::app()->createUrl('/user/autocompletelist');
$bizAutoCompleteURL = Yii::app()->createUrl('/business/autocompletelist');

$script = <<<EOD
	$('#RestaurantCertificate_business_id').select2({
        placeholder: "Search Business",
        width : "100%",
        minimumInputLength: 3,
        ajax: {
            url: "$bizAutoCompleteURL",
            dataType: 'json',
                data: function (term, page) {
                    return {
                        query: term
                      };
                },
                results: function (data, page) {
                    return {
                        results: data
                    };
                }
        }
	});

	$('#RestaurantCertificate_redeemer_user_id').select2({
        placeholder: "Search User",
        width : "100%",
        minimumInputLength: 3,
        ajax: {
            url: "$userAutoCompleteURL",
            dataType: 'json',
                data: function (term, page) {
                    return {
                        query: term
                      };
                },
                results: function (data, page) {
                    return {
                        results: data
                    };
                }
        }
	});
EOD;

Yii::app()->clientScript->registerScript('details', $script, CClientScript::POS_READY);

?>
