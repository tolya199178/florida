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

    <h3>Update Email template : <?php echo CHtml::encode($model->template_name); ?></h3>
        
        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mailtemplate-form',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'  => false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>	
        </div>
    <?php } ?>


    <?php echo $form->hiddenField($model,'template_id'); ?>    


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'template_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'template_name',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'template_name'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'subject',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'subject',array('class'=>"form-control")); ?>
                <?php echo $form->error($model,'subject'); ?>
            </div>        
        </div>	
	</div>
	
	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'msg',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-10">                
                <?php $this->widget('application.extensions.editor.CKkceditor',array(
    				"model"=>$model,                # Data-Model
    				"attribute"=>'msg',         	# Attribute in the Data-Model
    				"height"=>'300px',
    				"width"=>'90%',
    			    ) );
                ?>    
                <?php echo $form->error($model,'msg'); ?>
            </div>
        </div>	
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-default")); ?>
	</div>

<?php $this->endWidget(); ?>



