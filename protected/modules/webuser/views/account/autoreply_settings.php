
        <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'autoreply_giftcard_review',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textarea($model,'autoreply_giftcard_review',array('class'=>"form-control", "rows"=>4, "cols"=>100)); ?>
                    <?php echo $form->error($model,'autoreply_giftcard_review'); ?>
                </div>
            </div>
        </div>

        <br />