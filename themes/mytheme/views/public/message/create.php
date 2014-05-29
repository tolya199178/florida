<div class="message widget">
    <div>
<?php   $form=$this->beginWidget('CActiveForm', array(
                            'action'=> $this->createUrl('/message/create'),
                        	'id'=>'message_create_form',
                        	'enableAjaxValidation'=>false,
                     ));
?>

        <h1>Create a New Message</h1>
        <table>
        <tr>
            <th>Send To </th>
            <td>
                <?php echo CHtml::dropDownList('UserMessage[recipient]', '',
                                               CHtml::listData(MyFriend::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id, 'friend_status' => 'Approved')),
                                                       'friend_id',
                                                       function($friend) {
                                                           return CHtml::encode($friend->friend['last_name']).', '.CHtml::encode($friend->friend['first_name']);
                                                       }),
                                               array('empty' => '(Select a recipient)')
                                            );
                ?>
                <?php echo CHtml::error($model,'recipient'); ?>
            </td>
        </tr>
        <tr>
            <th>Subject</th>
            <td><?php echo $form->textField($model,'subject'); ?>
                <?php echo CHtml::error($model,'subject'); ?>
            </td>
        </tr>
        <tr>
            <td>Message</td>
            <td><div id='inbox_message'>
                <?php echo $form->textArea($model,'message', array('rows'=>7,'columns'=>100)); ?>
                </div>
                <?php echo CHtml::error($model,'message'); ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
            	<div class="row buttons">
    		      <?php echo CHtml::submitButton('Send Message'); ?>
    	        </div>
            </td>
        </tr>

        </table>
<?php   $this->endWidget(); ?>

    </div>
</div>