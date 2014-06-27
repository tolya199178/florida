<?php

    $model = $data['model'];

?>

<?php   $form=$this->beginWidget('CActiveForm', array(
                            // 'action'=> $this->createUrl('/message/create'),
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
                    <label for="inputEmail3" class="col-sm-2 control-label">Send To : </label>
                    <div class="col-sm-4">
                                <?php echo CHtml::dropDownList('UserMessage[recipient]', '',
                                                               CHtml::listData(MyFriend::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id, 'friend_status' => 'Approved')),
                                                                       'friend_id',
                                                                       function($friend) {
                                                                           return CHtml::encode($friend->friend['last_name']).', '.CHtml::encode($friend->friend['first_name']);
                                                                       }),
                                                               array('empty'        => '(Select a recipient)',
                                                                     'class'        => 'form-control',
                                                                     'data-toggle'  => 'tooltip',
                                                                     'title'        => 'Enter Recipient',
                                                                     'placeholder'  => 'Enter Recipient.')
                                                            );
                                ?>
                                <?php echo CHtml::error($model,'recipient'); ?>

                    </div>
                  </div>
            </div>


  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Subject</label>
    <div class="col-sm-8">
        <?php echo $form->textField($model,'subject', array('class'         => 'form-control',
                                                            'data-toggle'   => 'tooltip',
                                                            'title'         => 'Enter Subject',
                                                            'placeholder'   => 'Enter Subject')); ?>
        <?php echo CHtml::error($model,'subject'); ?>
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
    <div class="col-sm-8">

        <div id='inbox_message'>
            <?php echo $form->textArea($model,'message', array('class'                => 'form-control',
                                                               'data-toggle'   => 'tooltip',
                                                               'title'         => 'Enter Message',
                                                               'rows'          => 20,
                                                               'columns'       => 300,
                                                               'placeholder'   => 'Type your Message.')); ?>
        </div>
            <?php echo CHtml::error($model,'message'); ?>
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

