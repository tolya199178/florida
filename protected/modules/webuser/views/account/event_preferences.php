
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_upcoming_event_trip',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_upcoming_event_trip', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_upcoming_event_trip'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_upcoming_event_places_wantogo',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_upcoming_event_places_wantogo', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_upcoming_event_places_wantogo'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'alert_upcoming_event_places_visited',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'alert_upcoming_event_places_visited', array('Y' => 'Yes', 'N' => 'No'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'alert_upcoming_event_places_visited'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'event_alert_frequency',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->dropDownList($model, 'event_alert_frequency', array('Daily' => 'Daily', 'Immediately' => 'Immediately'), array('prompt'=>'Select Option', 'class'=>"form-control"));?>
                    <?php echo $form->error($model,'event_alert_frequency'); ?>
                </div>
            </div>
        </div>
