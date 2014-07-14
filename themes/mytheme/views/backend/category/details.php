<?php

// print_r($model);

?>


<style>

.form-group {
    padding-top:10px;
    padding-bottom:10px;
}
</style>

    <h3>Update Category : <?php echo CHtml::encode($model->category_name); ?></h3>

        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mailcategory-form',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'  => false,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>
        </div>
    <?php } ?>


    <?php echo $form->hiddenField($model,'category_id'); ?>


	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'category_name',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'category_name',array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter category", "data-original-title"=>"Enter Category.")); ?>
                <?php echo $form->error($model,'category_name'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'parent_id',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php
                      $parents = Category::model()->findAll('parent_id is null');
                      $data = $model->makeDropDown($parents);

                      echo $form->dropDownList($model,'parent_id',  $data,array('class'=>"form-control",
                          'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select parent", "data-original-title"=>"Select parent."));
                ?>
                <?php echo $form->error($model,'parent_id'); ?>
            </div>
        </div>
	</div>

	<div class="row">
        <div class="form-group">
            <?php echo $form->labelEx($model,'category_description',array('class'=>"col-sm-2 control-label")); ?>
            <div class="col-sm-4">
                <?php echo $form->textField($model,'category_description',array('class'=>"form-control",
                    'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select description", "data-original-title"=>"Select description.")); ?>
                <?php echo $form->error($model,'category_description'); ?>
            </div>
        </div>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-default")); ?>
	</div>

<?php $this->endWidget(); ?>



