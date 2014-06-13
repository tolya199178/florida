
<style>
#main {
	background-color: white;
	margin-top: 5px;
	position: relative;
}
</style>

    <div class="container">
        <div class="row">
            <div class="col-sm-12" id='main'>


                    <?php $form=$this->beginWidget('CActiveForm', array(
                    	'id'=>'profile-form',
                    	'enableAjaxValidation'=>false,
                    	'enableClientValidation'=>false,
                    	'clientOptions'=>array(
                    		'validateOnSubmit'=>true,
                    	),
                    	'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    	'focus'=>array($model,'username'),
                    )); ?>


                    <?php echo $form->errorSummary($model); ?>


                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'fldCurrentPassword',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'fldCurrentPassword',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'fldCurrentPassword'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'password'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'fldVerifyPassword',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'fldVerifyPassword',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'fldVerifyPassword'); ?>
                                </div>
                            </div>
                    	</div>


                    	<div class="row buttons">
                    		<?php echo CHtml::submitButton('Change your password', array('class'=>"btn btn-default")); ?>
                    	</div>

                    <?php $this->endWidget(); ?>


            </div>

        </div>
    </div>

