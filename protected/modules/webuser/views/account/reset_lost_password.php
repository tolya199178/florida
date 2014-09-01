
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

                        <?php echo $form->hiddenField($model,'request_token'); ?>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'email',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'email',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'email'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'new_password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'new_password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'new_password'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'confirm_new_password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'confirm_new_password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'confirm_new_password'); ?>
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

