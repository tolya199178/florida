 <?php
/* @var $this SavedSearchController */
/* @var $model SavedSearch */
/* @var $form CActiveForm */
?>
<?php

    $searchDetails = unserialize($model->search_details);

?>

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'saved-search-details-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // See class documentation of CActiveForm for details on this,
            // you need to use the performAjaxValidation()-method described there.
            'enableAjaxValidation'=>false,
        )); ?>

            <!-- modal-header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Update Saved Search</h4>
            </div>
            <!-- /modal-header -->

            <!-- modal-body -->
            <div class="modal-body">
                <div class="form">

                    <p class="note">Fields with <span class="required">*</span> are required.</p>

                    <?php echo $form->errorSummary($model); ?>

                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->labelEx($model,'search_name',array('class'=>"col-sm-3 control-label")); ?>
                            <div class="col-sm-9">
                                <?php echo $form->textField($model,'search_name',array('class'=>"form-control")); ?>
                                <?php echo $form->error($model,'search_name'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <?php echo CHtml::label('Search ','filter_activity',array('class'=>"col-sm-3 control-label")); ?>
                            <div class="col-sm-9">
                                <ul class="list-group">
                                    <li class="list-group-item text-muted">Search Details</li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong>Search to</strong></span>
                                       <?php echo CHtml::encode($searchDetails['dowhat']).' '.CHtml::encode($searchDetails['withwhat']); ?></li>
                                    <li class="list-group-item text-right"><span class="pull-left">
                                        <strong>When</strong></span><?php echo date('m-Y-d H:i:s', (int) $searchDetails['when']/1000); ?></li>
                                    <li class="list-group-item text-right"><span class="pull-left">
                                        <strong>Location</strong></span><?php echo CHtml::encode($searchDetails['where']); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Submit'); ?>
                    </div>


                </div><!-- form -->
            </div><!-- /modal-body -->

            <!-- modal-footer -->
            <div class="modal-footer">
                <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-default',  'data-dismiseds'=>"modal")); ?>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            <!-- /modal-footer -->

        <?php $this->endWidget(); ?>
