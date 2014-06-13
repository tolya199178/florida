
<style>
#main {
	background-color: white;
	/* top: 66px; */
	margin-top: -36px;
	position: relative;
}
</style>

    <div class="container">
        <!--  start anel -->
        <div class="row">
            <div class="col-sm-12" id='main'>


                    <?php $form=$this->beginWidget('CActiveForm', array(
                    	'id'=>'profile-form',
                    	'enableAjaxValidation'=>true,
                    	'enableClientValidation'=>false,
                    	'clientOptions'=>array(
                    		'validateOnSubmit'=>true,
                    	),
                    	'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    	'focus'=>array($model,'username'),
                    )); ?>

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
                                <?php echo $form->labelEx($model,'confirm_password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'confirm_password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'confirm_password'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'confirm_password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'confirm_password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'confirm_password'); ?>
                                </div>
                            </div>
                    	</div>


                    	<div class="row buttons">
                    		<?php echo CHtml::submitButton('Create your Account', array('class'=>"btn btn-default")); ?>
                    	</div>

                    <?php $this->endWidget(); ?>


            </div>

        </div>
    </dic>

