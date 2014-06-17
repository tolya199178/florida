
<style>
#main {
	background-color: white;
	margin-top: 5px;
	position: relative;
}
</style>

    <div class="container">
        <div class="row">
           <div class="col-sm-6 col-sm-offset-3" id='main'>

           <br />

           <div class="panel panel-warning">
                <div class="panel-heading">
                    Change Password
                </div>
                <div class="panel-body">

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
                                <?php echo $form->labelEx($model,'email',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'email',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'email'); ?>
                                </div>
                            </div>
                    	</div>

                        <br />

                    	<div class="row buttons">
                    		<?php echo CHtml::submitButton('Recover your password', array('class'=>"btn btn-success")); ?>
                    	</div>

                    <?php $this->endWidget(); ?>


                </div>
           </div




            </div>

        </div>
    </div>

