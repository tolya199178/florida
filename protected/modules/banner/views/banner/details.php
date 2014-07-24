<?php
/* @var $this BannerController */
/* @var $model Banner */
/* @var $form CActiveForm */
?>
<?php

    $model              = $data['model'];
    $myBusinessList     = $data['myBusinessList'];


    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);

?>
<style>
.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update Banner : <?php echo CHtml::encode($model->banner_title); ?></h3>

    <div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'banner-details-form',
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

    <?php echo $form->hiddenField($model,'banner_id'); ?>

    <?php echo $form->errorSummary($model); ?>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_title',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_title',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_title'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_description',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textArea($model,'banner_description',array('class'=>"form-control",  'rows' => 4, 'cols' => 300)); ?>
                        <?php echo $form->error($model,'banner_description'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_url',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_url',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_url'); ?>
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

<?php       if (!empty($model->banner_photo)) { ?>
        	<div class="row">
                <div class="form-group">
                    <span class="col-sm-2 control-label">Current Image</span>
                    <div class="col-sm-4">
                        <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                            <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/banner/thumbnails/'.$model->banner_photo,
                                                    "Image",
                                                    array('width'=>150, 'height'=>150))); ?>
                        </div>
                    </div>
                </div>
        	</div>
<?php       } ?>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'lstBannerPages',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
                        <?php echo CHtml::hiddenField('lstBannerPages', '', array ('id'=>'lstBannerPages')); ?>
	                    <?php echo $form->error($model,'lstBannerPages'); ?>
	                </div>
	            </div>
	    	</div>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_id',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,'business_id', $myBusinessList, array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_id'); ?>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_view_limit',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php echo $form->textField($model,'banner_view_limit',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_view_limit'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_expiry',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'banner_expiry',
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
                        <?php echo $form->error($model,'banner_expiry'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_status',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <?php echo $form->dropDownList($model, 'banner_status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('prompt'=>'Select Status', 'class'=>"form-control"));?>
                        <?php echo $form->error($model,'banner_status'); ?>
                    </div>
                </div>
            </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php

$pageAutoCompleteURL = Yii::app()->createUrl('/banner/banner/autocompletepagelist');

$script = <<<EOD
	$('#lstBannerPages').select2({
        placeholder: "Search Pages",
        width : "100%",
        multiple:true,
       //  minimumInputLength: 3,
        ajax: {
            url: "$pageAutoCompleteURL",
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
