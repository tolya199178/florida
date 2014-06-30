<?php

    $model = $data['model'];

?>

<?php   $form=$this->beginWidget('CActiveForm', array(
                        	'id'=>'message_create_form',
                            'htmlOptions'=>array(
                                'class'=>'form-horizontal',
                                'role'=>"form",
                             ),
                        	'enableAjaxValidation'=>false,
                     ));
?>

            <div class="row">
                  <div class="form-group">
                    <label for="recipient" class="col-sm-2 control-label">Send To : </label>
                    <div class="col-sm-4">
                                <?php echo CHtml::dropDownList('UserMessage[recipient]', $model->recipient,
                                                               CHtml::listData(MyFriend::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id, 'friend_status' => 'Approved')),
                                                                       'friend_id',
                                                                       function($friend) {
                                                                           return CHtml::encode($friend->friend['last_name']).', '.CHtml::encode($friend->friend['first_name']);
                                                                       }),
                                                               array('empty'        => '(Select a recipient)',
                                                                     'class'        => 'form-control',
                                                                     'data-toggle'  => 'tooltip',
                                                                     'title'        => 'Enter Recipient',
                                                                     'placeholder'  => 'Enter Recipient.',
                                                                     'disabled'     => (!empty($model->recipient)?'disabled':''))
                                                            );
                                ?>
                                <?php echo CHtml::error($model,'recipient'); ?>

                    </div>
                  </div>
            </div>

            <div class="row">
                  <div class="form-group">
                    <label for="send_as" class="col-sm-2 control-label">Send As : </label>
                    <div class="col-sm-4">
                                <?php echo CHtml::dropDownList('UserMessage[send_as]', '',
                                                               array('email' => 'Email (Default)', 'sms' => 'SMS', 'both' => 'Both'),
                                                               array('empty'        => '(Send Message as eMail or SMS)',
                                                                     'class'        => 'form-control',
                                                                     'data-toggle'  => 'tooltip',
                                                                     'title'        => 'Send Message as eMail or SMS',
                                                                     'id'           => 'send_as')
                                                            );
                                ?>
                                <?php echo CHtml::error($model,'recipient'); ?>

                    </div>
                  </div>
            </div>

            <div id="mail_form_fields">

                <div class="row">


                  <div class="form-group">
                    <label for="subject" class="col-sm-2 control-label">Subject</label>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model,'subject', array('class'         => 'form-control',
                                                                            'data-toggle'   => 'tooltip',
                                                                            'title'         => 'Enter Subject',
                                                                            'placeholder'   => 'Enter Subject')); ?>

                        <br/>

                        <div class="alert alert-warning" id="both_warning">

                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <strong>Warning! SMS messages will be truncated.</strong><br/>
                                    You have chosen both send methods. The Subject will be ignored and only the first 140
                                    characters of the message will be sent via SMS.

                        </div>


                        <?php echo CHtml::error($model,'subject'); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-8">

                        <div id='inbox_message'>
                            <?php echo $form->textArea($model,'message', array('class'                => 'form-control',
                                                                               'data-toggle'   => 'tooltip',
                                                                               'title'         => 'Enter Message',
                                                                               'rows'          => 20,
                                                                               'columns'       => 300,
                                                                               'placeholder'   => 'Type your Message.',
                            'size'=>150,'maxlength'=>150)); ?>
                        </div>
                            <?php echo CHtml::error($model,'message'); ?>
                        </div>
                  </div>
              </div>

            </div>
            <div id="sms_form_fields">
               <div class="row">


                  <div class="form-group">
                    <label for="smsmessage" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-8">
                        <?php echo CHtml::textField('UserMessage[smsmessage]','',
                                                    array('class'         => 'form-control',
                                                          'data-toggle'   => 'tooltip',
                                                          'title'         => 'Type your SMS message',
                                                          'placeholder'   => 'Type your SMS message')); ?>
                        <?php echo CHtml::error($model,'subject'); ?>
                    </div>
                  </div>
               </div>

            </div>



          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
            	<div class="row buttons">
        		      <?php echo CHtml::submitButton('Submit', array('class'=>"btn btn-default")); ?>
                </div>
            </div>
          </div>
<?php   $this->endWidget(); ?>



<?php
$script = <<<EOD

        $("#sms_form_fields").hide();
        $("#both_warning").hide();

        $("body").on('change', "#send_as", function (e) {


            $("#both_warning").hide();

            var send_as = $("#send_as").val();
            if (send_as == 'email')
            {
                $("#sms_form_fields").hide();
                $("#mail_form_fields").show();
            }
            if (send_as == 'sms')
            {
                $("#sms_form_fields").show();
                $("#mail_form_fields").hide();
            }
            if (send_as == 'both')
            {
                $("#both_warning").show();
                $("#sms_form_fields").hide();
                $("#mail_form_fields").show();
            }

        });

EOD;

Yii::app()->clientScript->registerScript('create_message', $script, CClientScript::POS_READY);

?>