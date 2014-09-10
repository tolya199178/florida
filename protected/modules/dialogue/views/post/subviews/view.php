<?php

$modelQuestion  = $data['modelQuestion'];
$listAnswers    = $data['listAnswers'];

?>

<?php

$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/css/dialogue/dialogue.css');

?>

<?php
 $script = <<<EOD

            $('.qa-vote-up, .qa-vote-down').on('click',function(event){

                event.preventDefault();

                var url         = $(this).attr('href');
                var target      = $(this).attr('target');

        		// process the form. Note that there is no data send as posts arguements.
        		$.ajax({
        			type 		: 'POST',
        			url 		: url,
        		    data 		: null,
        			dataType 	: 'json'
        		})
        		// using the done promise callback
        		.done(function(data) {

                    if (data.result == false)
                    {
                        alert(data.message);
                        return false;
                    }

                    $('#'+target).html(data.votes);


        		});

                return false;


           });

            $('.editpost').on('click',function(event){

                event.preventDefault();

                var url     = $(this).attr('href');
                var type    = $(this).attr('posttype');
                var target  = $(this).attr('target');

        		$.ajax({
        			type 		: 'GET',
        			url 		: url,
        		    data 		: null,
        			dataType 	: 'json'
        		})
        		// using the done promise callback
        		.done(function(data) {

                    if (data.result == false)
                    {
                        alert(data.message);
                        return false;
                    }

                    // Move the form to qa-view-text
                    $('#'+target).replaceWith($("#edit_form_container").html());
                    $("#edit_form_container").remove();

                    $('#post_id').val(data.postdata.id);
                    $('#post_type').val(data.posttype);
                    $('#post_content').val(data.postdata.content);

                    $('#edit-form').get(0).setAttribute('action', url);

        		});

                return false;

           });

EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

<style>
<!--
.green {
    color: green;
}

glyphicon.green {
    font-size: 3.4em;
}
-->
</style>

<div class="container" style="background:#fff;">
    <div class="qa-view row">
        <div class="col-md-12">
            <div class="qa-view-question">
                <div class="qa-view-actions">
                    <?php $this->renderPartial("subviews/vote",array('model' => $modelQuestion, 'type' => 'question')); ?>
                </div>

                <div class="qa-view-body">
                    <?php $this->renderPartial("subviews/post",array('model' => $modelQuestion, 'type' => 'question')); ?>
                </div>
            </div>

<?php
            $linkedItem = '';

            if (!empty($modelQuestion->entity_id)) {
                if ($modelQuestion->entity_type == 'city') {
                    $linkedItem = CHtml::link('Click here to view the linked city', Yii::app()->createURL('location/location/viewcity', array('city_id'=>$modelQuestion->entity_id)));
                }
                if ($modelQuestion->entity_type == 'business') {
                    $linkedItem = CHtml::link('Click here to view the linked business', Yii::app()->createURL('business/business/showdetails', array('business_id'=>$modelQuestion->entity_id)));
                }
                if ($modelQuestion->entity_type == 'user') {
                    $linkedItem = CHtml::link('Click here to view the linked user', Yii::app()->createURL('webuser/profile/show/', array('user_id'=>$modelQuestion->entity_id)));
                }
                if ($modelQuestion->entity_type == 'event') {
                    $linkedItem = CHtml::link('Click here to view the linked event', Yii::app()->createURL('calendar/calendar/showevent', array('event'=>$modelQuestion->entity_id)));
                }
            }
?>
            <div>
                <?php  echo $linkedItem; ?>
                <p>&nbsp;</p>
            </div>


            <div class="qa-view-answers-heading clearfix">
                <h3 class="qa-view-title">
                    <?php echo  ((count($listAnswers) == 0)?'No Answers yet': ((count($listAnswers) == 1)?'One Answer.': count($listAnswers).' answers.') ); ?>
                </h3>

            </div>

            <div class="qa-view-answers">
                <?php foreach ($listAnswers as $row) { ?>
                    <div class="qa-view-answer">
                        <div class="qa-view-actions">

                            <?php $this->renderPartial("subviews/vote",array('model' => $row, 'type' => 'answer')); ?>

                        </div>
                        <div class="qa-view-body">
                            <?php $this->renderPartial("subviews/post",array('model' => $row, 'type' => 'answer')); ?>
                        </div>
                    </div>
                <?php } ?>

            </div>


            <div class="qa-view-answer-form">

                <div id='postanswer_form'>
                <?php

                    $answer = new PostAnswer;

                    $form=$this->beginWidget('CActiveForm', array(
                    	'id'=>'profile-form',
                        'action'=>Yii::app()->createUrl('//dialogue/post/answer/'),
                    ));
                ?>

                    <?php echo $form->errorSummary($answer); ?>
                    <?php $answer->question_id = $modelQuestion->id; ?>
                    <?php echo $form->hiddenField($answer, 'question_id'); ?>

                    <div class="form-group field-answer-content required">
                    <label for="answer-content" class="control-label"></label>
                        <?php echo $form->textArea($answer,'content', array('rows' => 6, 'class' => 'form-control')); ?>
                    <div class="help-block"></div>
                    </div>


                    <?php echo CHtml::checkBox('PostAnswer[notify_updates]', false, array('id'=>'notify_updates', 'class'=>'')); ?> Notify me of updates.



                        <div class="form-group">
                    	   <?php echo CHtml::submitButton(($answer->isNewRecord ? 'Create' : 'Update'), array('class'=>"btn btn-inverse")); ?>
                        </div>

                <?php $this->endWidget(); ?>
                </div><!-- postanswer_form -->


            </div>


        </div>
    </div>
</div>

<div id='edit_form_container' style="display:none;">
    <form id="edit-form" action="#" method="post">
        <input name="static_question_id" id="static_question_id" type="hidden" value="<?php echo $modelQuestion->id; ?>" />
        <input name="post_id" id="post_id" type="hidden" value="" />
        <input name="post_type" id="post_type" type="hidden" value="" />
        <div class="form-group field-answer-content required">
            <label for="answer-content" class="control-label"></label>
            <textarea rows="6" class="form-control" name="post_content" id="post_content"></textarea>
            <div class="help-block"></div>
        </div>
        <div class="form-group">
    	<input class="btn btn-inverse" type="submit" name="yt0" value="Save Updated Post" />    </div>
    </form>
</div>
