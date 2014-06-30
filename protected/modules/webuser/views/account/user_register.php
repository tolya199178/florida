<?php
//print_r($model);
//exit;
?>
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
            <br />
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-warning">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Register your Account
                        </h3>
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

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'first_name',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'first_name',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'first_name'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'last_name',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->textField($model,'last_name',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'last_name'); ?>
                                </div>
                            </div>
                        </div>

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
                                <?php echo $form->labelEx($model,'password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->passwordField($model,'password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'password'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'confirm_password',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <?php echo $form->passwordField($model,'confirm_password',array('class'=>"form-control")); ?>
                                    <?php echo $form->error($model,'confirm_password'); ?>
                                </div>
                            </div>
                    	</div>

                    	<div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'places_visited',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <div style="overflow:auto; height: 200px">
                                        <?php echo $form->CheckBoxList($model,'places_visited', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name')); ?>
                                    </div>
                                    <?php echo $form->error($model,'places_visited'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,'places_want_to_visit',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-4">
                                    <div style="overflow:auto; height: 200px">
                                        <?php echo $form->CheckBoxList($model,'places_want_to_visit', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name')); ?>
                                    </div>
                                    <?php echo $form->error($model,'places_want_to_visit'); ?>
                                </div>
                            </div>
                        </div>


                    	<div class="control-group">
                    		<?php echo $form->labelEx($model,'picture'); ?>
                    		<?php echo $form->fileField($model,'picture'); ?>
                    		<?php echo $form->error($model,'picture'); ?>
                    	</div>
                    	<div class="control-group">
                    		<?php echo $form->label($model,'removePicture', array('label'=>$form->checkBox($model,'removePicture').$model->getAttributeLabel('removePicture'), 'class'=>'checkbox')); ?>
                    		<?php echo $form->error($model,'removePicture'); ?>
                    	</div>

                        <?php if(CCaptcha::checkRequirements()) { ?>
                        	<div class="row">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model,'verifyCode',array('class'=>"col-sm-2 control-label")); ?>
                                    <div class="col-sm-4">
                                        <?php $this->widget('CCaptcha'); ?>
                                        <?php echo $form->error($model,'verifyCode'); ?>
                                        <div class="hint">Please enter the letters as they are shown in the image above.
                                        <br/>Letters are not case-sensitive.</div>
                                        <?php echo $form->textField($model,'verifyCode'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <p>&nbsp;</p>

                    	<div class="row buttons">
                    		<?php echo CHtml::submitButton('Create your Account', array('class'=>"btn btn-success btn-lg")); ?>
                    	</div>

                    <?php $this->endWidget(); ?>

                    </div>
                </div>
            </div>

        </div>
        <!--  end panel -->
    </div>

