<?php
/* @var $this TripLegController */
/* @var $model TripLeg */
/* @var $form CActiveForm */
?>

<div class="row">

    <div class="col-sm-6">

        <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'trip-leg-trip_leg_details-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // See class documentation of CActiveForm for details on this,
            // you need to use the performAjaxValidation()-method described there.
            'enableAjaxValidation'=>false,
        )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

                    <?php echo $form->hiddenField($model,'trip_id'); ?>

                	<div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'city_id',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-10">
                                <?php echo $form->dropDownList($model,'city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name'), array('class'=>"form-control")); ?>
                                <?php echo $form->error($model,'city_id'); ?>
                            </div>
                        </div>
                	</div>

                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'description',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textarea($model,'description',array('class'=>"form-control", "rows"=>4, "cols"=>100)); ?>
                                <?php echo $form->error($model,'description'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'leg_start_date',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'leg_start_date',array('class'=>"form-control")); ?>
                                <?php echo $form->error($model,'leg_start_date'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'leg_end_date',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-10">
                                <?php echo $form->textField($model,'leg_end_date',array('class'=>"form-control")); ?>
                                <?php echo $form->error($model,'leg_end_date'); ?>
                            </div>
                        </div>
                    </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Submit'); ?>
            </div>

        <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>

    <div class="col-sm-6">

        <div id="who_is_going">
        </div>

    </div>

</div>
