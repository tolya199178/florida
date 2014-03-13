 <?php
/* @var $this BusinessController */
/* @var $model Business */
/* @var $form CActiveForm */
?>

<style>

.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update Business : <?php echo $model->business_name; ?></h3>
        
        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-details-form',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'  => false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>	
        </div>
    <?php } ?>


    <?php echo $form->hiddenField($model,'business_id'); ?>    


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
            <?php echo $form->labelEx($model,'business_description',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-10">                
                <?php $this->widget('application.extensions.editor.CKkceditor',array(
    				"model"=>$model,                # Data-Model
    				"attribute"=>'business_description',         	# Attribute in the Data-Model
    				"height"=>'220px',
    				"width"=>'75%',
    			    ) );
                ?>    
                <?php echo $form->error($model,'business_description'); ?>
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
            <?php echo $form->labelEx($model,'business_phone',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'business_phone',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'business_phone'); ?>
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
                <?php echo $form->dropDownList($model,'business_city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name')); ?> 
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
            <?php echo $form->labelEx($model,'add_request_processed_by',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'add_request_processed_by',array('class'=>"form-control",'readonly' => 'readonly')); ?>
                <?php echo $form->error($model,'add_request_processed_by'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'add_request_rejection_reason',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'add_request_rejection_reason',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'add_request_rejection_reason'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'claimed_by',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'claimed_by',array('class'=>"form-control", 'readonly' => 'readonly')); ?>
                <?php echo $form->error($model,'claimed_by'); ?>
            </div>        
        </div>	
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'claim_rejection_reason',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'claim_rejection_reason',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'claim_rejection_reason'); ?>
            </div>        
        </div>	
	</div>


	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'activation_code',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'activation_code',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'activation_code'); ?>
            </div>        
        </div>	
	</div>
	

	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'business_allow_review',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'business_allow_review', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>                
                <?php echo $form->error($model,'business_allow_review'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'business_allow_rating',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'business_allow_rating', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
                <?php echo $form->error($model,'business_allow_rating'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'is_active',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'is_active', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>            
                <?php echo $form->error($model,'is_active'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'is_featured',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'is_featured', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>            
                <?php echo $form->error($model,'is_featured'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'is_closed',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->checkBox($model,'is_featured', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
                <?php echo $form->error($model,'is_closed'); ?>
            </div>        
        </div>	
	</div>
	
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'claim_status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,
                                               'claim_status',
                                               $model->listClaimStatus(),
                                               array('prompt'=>'Select Status')
                );?>
                <?php echo $form->error($model,'claim_status'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'activation_status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,
                                               'activation_status',
                                               $model->listActivationStatus(),
                                               array('prompt'=>'Select Status')
                );?>
            <?php echo $form->error($model,'activation_status'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'add_request_processing_status',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->dropDownList($model,
                                               'add_request_processing_status',
                                               $model->listAddRequestProcessingStatus(),
                                               array('prompt'=>'Select Status')
                );?>
                <?php echo $form->error($model,'add_request_processing_status'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'business_keywords',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'business_keywords',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'business_keywords'); ?>
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
	
<?php if (!empty($model->image)) { ?>
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

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-default")); ?>
	</div>

<?php $this->endWidget(); ?>



