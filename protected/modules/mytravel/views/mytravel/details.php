<?php
/* @var $this TripController */
/* @var $model Trip */
/* @var $form CActiveForm */

$model = $data['model'];

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'trip-details-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Trip Details <i class="fa fa-link fa-1x"></i>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'trip_name',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-4">
                                <?php echo $form->textField($model,'trip_name',array('class'=>"form-control")); ?>
                                <?php echo $form->error($model,'trip_name'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'trip_status',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-4">
                                <?php echo $form->dropDownList($model, 'trip_status',
                                                               $model->listTripStatus(),
                                                               array('prompt'=>'Select Status', 'class'=>"form-control")
                                                  );
                                ?>
                                <?php echo $form->error($model,'trip_status'); ?>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'description',array('class'=>"col-sm-2 control-label")); ?>
                            <div class="col-sm-4">
                                <?php echo $form->textarea($model,'description',array('class'=>"form-control", "rows"=>10, "cols"=>100)); ?>
                                <?php echo $form->error($model,'description'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Submit'); ?>
                    </div>

                </div>
            </div>
<?php $this->endWidget(); ?>
</div><!-- form -->


<?php if (!$model->isNewRecord) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Destinations <i class="fa fa-link fa-1x"></i>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php foreach ($model->tripLegs as $itemLeg) { ?>
                            <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/mytravel/mytravel/details', array('id' => $itemLeg->trip_leg_id))?>"><?php echo CHtml::encode($itemLeg->description); ?></a></li>

                            <a class="btn btn-xs btn-default" id="who_is_going"
                               href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/whoisgoing/', array('leg'=>$itemLeg->trip_leg_id)); ?>">
                                <i class="glyphicon glyphicon-plus-sign"></i>
                                Who is going
                            </a>
                            <a class="btn btn-xs btn-default" id="offers"
                               href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/offers/', array('city'=>$itemLeg->city_id)); ?>">
                                <i class="glyphicon glyphicon-plus-sign"></i>
                                Check Specials
                            </a>
                        <?php }?>




                    </ul>

                    <a class="btn btn-sm btn-success" id="add_leg" href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/addleg/', array('trip'=>$model->trip_id)); ?>">
                        <i class="glyphicon glyphicon-plus-sign"></i>
                        Add a Leg
                    </a>

                    <div id="legform">

                    </div>
                </div>
            </div>


<?php } ?>


            <!-- Trip q and a --->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Take Advice for the trip <i class="fa fa-link fa-1x"></i>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php foreach ($model->tripQuestions as $itemQuestion) { ?>
                            <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/mytravel/mytravel/details', array('id' => $itemLeg->trip_leg_id))?>"><?php echo CHtml::encode($itemLeg->description); ?></a></li>

                            <a class="btn btn-xs btn-default" id="who_is_going"
                               href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/whoisgoing/', array('leg'=>$itemLeg->trip_leg_id)); ?>">
                                <i class="glyphicon glyphicon-plus-sign"></i>
                                Who is going
                            </a>
                            <a class="btn btn-xs btn-default" id="offers"
                               href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/offers/', array('city'=>$itemLeg->city_id)); ?>">
                                <i class="glyphicon glyphicon-plus-sign"></i>
                                Check Specials
                            </a>
                        <?php }?>




                    </ul>

                    <a class="btn btn-sm btn-success" id="add_leg" href="<?php echo Yii::app()->createUrl('/mytravel/mytravel/addleg/', array('trip'=>$model->trip_id)); ?>">
                        <i class="glyphicon glyphicon-plus-sign"></i>
                        Add a Leg
                    </a>

                    <div id="legform">

                    </div>
                </div>
            </div>
            <!-- ./Trip q and a --->



<?php

$baseUrl = $this->createAbsoluteUrl('/');

$baseUrl = $this->createAbsoluteUrl('/mytravel/mytravel/manage/trip/1');


$script = <<<EOD

    $("body").on('click', "#add_leg", function (e) {

    	var addressValue = $(this).attr("href");
    	   $("#legform").load(addressValue);

        return false;
    });


EOD;

Yii::app()->clientScript->registerScript('friend_list', $script, CClientScript::POS_READY);

?>