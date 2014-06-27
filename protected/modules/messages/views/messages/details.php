<?php

    $model = $data['model'];

?>
        <!-- Message menu bar -->

        <div class="row">

            <div class="col-sm-9 col-md-10">
                <!-- Split button -->

                <a href="<?php echo $this->createUrl('/messages/messages/reply/', array('message' => $model->id)); ?>"
                    type="button" class="btn btn-default"
                    data-toggle="tooltip" title="Reply">
                    <span class="glyphicon glyphicon-share-alt"></span>
                </a>

                <div class="btn-group">
                    <a href="<?php echo $this->createUrl('/messages/messages/archive/', array('message' => $model->id)); ?>"
                       type="button" class="btn btn-default"
                        data-toggle="tooltip" title="Archive">
                        <span class="glyphicon glyphicon-transfer"></span>
                    </a>


                    <a href="<?php echo $this->createUrl('/messages/messages/delete/', array('message' => $model->id)); ?>"
                        type="button" class="btn btn-default"
                        data-toggle="tooltip" title="Delete">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </div>


<!--                 <div class="btn-group"> -->
<!--                     <a class="btn btn-md btn-success" -->
<!--                         href="< ? php echo Yii::app()->createUrl('messages/messages/create'); ? >"> -->
<!--                         <i class="glyphicon glyphicon-plus-sign"></i> New Message -->
<!--                     </a> -->
<!--                 </div> -->

<!--                 <div class="pull-right"> -->
<!--                     <span class="text-muted"><b>1</b>–<b>50</b> of <b>277</b></span> -->
<!--                     <div class="btn-group btn-group-sm"> -->
<!--                         <button type="button" class="btn btn-default"> -->
<!--                             <span class="glyphicon glyphicon-chevron-left"></span> -->
<!--                         </button> -->
<!--                         <button type="button" class="btn btn-default"> -->
<!--                             <span class="glyphicon glyphicon-chevron-right"></span> -->
<!--                         </button> -->
<!--                     </div> -->
<!--                 </div> -->

            </div>

        </div>
        <!-- ./Message menu bar -->
            <div class="row">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Sent From : </label>
                    <div class="col-sm-4">
                            <?php echo CHtml::encode($model->sender_user->last_name.','.$model->sender_user->first_name); ?>
                    </div>
                  </div>
            </div>

            <div class="row">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Subject : </label>
                    <div class="col-sm-4">
                            <?php echo CHtml::encode($model->subject); ?>
                    </div>
                  </div>
            </div>

            <div class="row">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Message : </label>
                    <div class="col-sm-12">
                        <div id='message_text' style='width:90%;height:300px; overflow:auto;'>
                            <pre><?php echo CHtml::encode($model->message); ?>
                            </pre>
                        </div>
                    </div>
                  </div>
            </div>

