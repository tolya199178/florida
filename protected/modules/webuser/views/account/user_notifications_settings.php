        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_business_review',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_business_review', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_business_review'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_review_comment',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_review_comment', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_review_comment'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_like_complaint_response',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_like_complaint_response', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_like_complaint_response'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_forum_response',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_forum_response', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_forum_response'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_answer_voted',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_answer_voted', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_answer_voted'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_trip_question_response',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_trip_question_response', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_trip_question_response'); ?>
                </div>
            </div>
        </div>