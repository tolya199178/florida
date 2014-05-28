<div class="message widget">
    <div>
<?php   $form=$this->beginWidget('CActiveForm', array(
                            'action'=> $this->createUrl('/message/reply/', array('message' => $model->id)),
                        	'id'=>'message_reply_form',
                        	'enableAjaxValidation'=>false,
                     ));
?>

        <h1>Reply to message</h1>
        <table>
        <tr>
            <th>Reply To </th>
            <td><?php echo $model->sender_user->last_name.','.$model->sender_user->first_name; ?></td>
        </tr>
        <tr>
            <th>Subject</th>
            <td><?php echo $form->textField($model,'subject'); ?></td>
        </tr>
        <tr>
            <th>Message</th>
            <td><div id='inbox_message'>
                <?php echo $form->textArea($model,'message', array('rows'=>7,'columns'=>100)); ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
            	<div class="row buttons">
    		      <?php echo CHtml::submitButton('Send Reply'); ?>
    	        </div>
            </td>
        </tr>
        </table>
<?php   $this->endWidget(); ?>

    </div>
</div>