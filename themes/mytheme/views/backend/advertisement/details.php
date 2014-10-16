<?php
/* @var $this AdvertisementController */
/* @var $model Advertisement */
/* @var $form CActiveForm */
?>

<style>

    .form-group {
        padding-top:10px;
        padding-bottom:10px;
    }
</style>

<div class="form">
    <h3>Update Advertisement : <?php echo CHtml::encode($model->title); ?></h3>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'advertisement-details-form',
        'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),

    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'title',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'title',array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter the advertisement title", "data-original-title"=>"Enter the advertisement title."
                )); ?>
                <?php echo $form->error($model,'title'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'content',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-10">
                <?php $this->widget('application.extensions.editor.CKkceditor',array(
                    "model"=>$model,                # Data-Model
                    "attribute"=>'content',         	# Attribute in the Data-Model
                    "height"=>'300px',
                    "width"=>'90%',
                ) );
                ?>
                <?php echo $form->error($model,'content'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'user_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'user_id', CHtml::listData(User::model()->findAll(), 'user_id', 'fullname'), array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select user", "data-original-title"=>"Select user.")); ?>
                <?php echo $form->error($model,'user_id'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'business_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,'business_id', CHtml::listData(Business::model()->findAll(), 'business_id', 'business_name'), array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select business", "data-original-title"=>"Select business.")); ?>
                <?php echo $form->error($model,'business_id'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'advert_type',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">

                <?php echo $form->dropDownList($model,
                    'advert_type',
                    $model->listType(),
                    array('prompt'=>'Select Type','class'=>"form-control",
                        'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select type", "data-original-title"=>"Select type.")
                );?>
                <?php echo $form->error($model,'advert_type'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'custom_code',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-10">
                <?php $this->widget('application.extensions.editor.CKkceditor',array(
                    "model"=>$model,                # Data-Model
                    "attribute"=>'custom_code',         	# Attribute in the Data-Model
                    "height"=>'300px',
                    "width"=>'90%',
                ) );
                ?>
                <?php echo $form->error($model,'custom_code'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'published',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'published', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Check if published", "data-original-title"=>"Check if published.")); ?>
                <?php echo $form->error($model,'published'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'fldUploadImage',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo CHtml::activeFileField($model,'fldUploadImage',array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Upload image", "data-original-title"=>"Upload image.")); ?>
                <?php echo $form->error($model,'fldUploadImage'); ?>
            </div>
        </div>
    </div>

    <?php if (!empty($model->image)) { ?>
        <div class="row">
            <div class="form-group">
                <span class="col-sm-2 control-label">Image</span>
                <div class="col-sm-4">
                    <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                        <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/advertisement/thumbnails/'.$model->image,
                            "Image",
                            array('width'=>150, 'height'=>150))); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'expiry_date',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'attribute'=>'expiry_date',
                        'model'=>$model,
                        'options' => array(
                            'mode'=>'focus',
                            'dateFormat'=>'yy/m/d',
                            'showAnim' => 'slideDown',
                        ),
                        'htmlOptions'=>array('size'=>30,'class'=>'date form-control',
                            'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title'=>'Select expiry date', 'data-original-title'=>'Select expiry date.'),
                    ));
                ?>
                <?php echo $form->error($model,'expiry_date'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'maximum_ads_views',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo (!empty($model->maximum_ads_views))?$model->maximum_ads_views:'0'; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'maximum_ads_clicks',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo (!empty($model->maximum_ads_clicks))?$model->maximum_ads_clicks:'0'; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'ads_views',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo (!empty($model->ads_views))?$model->ads_views:'0'; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'ads_clicks',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo (!empty($model->ads_clicks))?$model->ads_clicks:'0'; ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->