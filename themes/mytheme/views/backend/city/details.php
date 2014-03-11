<?php
$script = <<<EOD

function changeUserType(obj)
{

   alert(obj)
}


EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_LOAD);

?>


<style>

.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update City: <?php echo $model->city_name; ?></h3>
        
        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'  => false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>	
        </div>
    <?php } ?>


    <?php echo $form->hiddenField($model,'city_id'); ?>    


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'city_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'city_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'city_name'); ?>
            </div>        
        </div>	
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'city_alternate_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'city_alternate_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'city_alternate_name'); ?>
            </div>
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'is_featured',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->error($model,'is_featured'); ?>
                <?php echo $form->checkBox($model,'is_featured', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
            </div>
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'city_alternate_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'city_alternate_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'city_alternate_name'); ?>
            </div>
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'description',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-10">                
                <?php $this->widget('application.extensions.editor.CKkceditor',array(
    				"model"=>$model,                # Data-Model
    				"attribute"=>'description',         	# Attribute in the Data-Model
    				"height"=>'300px',
    				"width"=>'90%',
    			    ) );
                ?>    
                <?php echo $form->error($model,'description'); ?>
            </div>
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'more_information',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-10">                
                <?php $this->widget('application.extensions.editor.CKkceditor',array(
    				"model"=>$model,                # Data-Model
    				"attribute"=>'more_information',         	# Attribute in the Data-Model
    				"height"=>'300px',
    				"width"=>'90%',
    			    ) );
                ?>    
                <?php echo $form->error($model,'more_information'); ?>
            </div>
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'image',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo CHtml::activeFileField($model,'image',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'image'); ?>
            </div>
        </div>	
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-default")); ?>
	</div>

<?php $this->endWidget(); ?>



