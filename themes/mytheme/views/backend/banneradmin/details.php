<?php
/* @var $this BannerController */
/* @var $model Banner */
/* @var $form CActiveForm */
?>

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

            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_id',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_id',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'business_id'); ?>
                    </div>
                </div>
            </div>
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
                    <?php echo $form->labelEx($model,'banner_url',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_url',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_url'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_view_limit',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_view_limit',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_view_limit'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_views',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_views',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_views'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_clicks',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_clicks',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_clicks'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_description',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_description',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_description'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_photo',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_photo',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_photo'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_expiry',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_expiry',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_expiry'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'banner_status',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'banner_status',array('class'=>"form-control")); ?>
                        <?php echo $form->error($model,'banner_status'); ?>
                    </div>
                </div>
            </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->