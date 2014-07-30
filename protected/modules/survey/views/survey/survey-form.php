<style type="text/css">
    #survey_name, .question-type-field, .question-field {
        width: 300px;
    }
    .form-row {
        margin-bottom: 40px;
    }
    .question {
        margin: 20px 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid #cccccc;
    }
    .question-options {
        margin-left: 20px;
    }
    .question-type-field {
        width: 300px;
    }
    .question-field {
        width: 300px;
    }
</style>

<?php 
    $surveyId = 0;
    $surveyName = '';
    $surveyQuestions = array();
    
    if($survey) {
        $surveyId = $isTemplate ? 0 : $survey->survey_id;
        $surveyName = $isTemplate ? 'New Survey' : $survey->survey_name;
        $surveyQuestions = $survey->surveyQuestions;
    }
?>

<div class="hidden">
    <div id="question-template">
        <?php $this->renderPartial('question-template', array('questionTypes' => $questionTypes, 'question' => null, 'questionName' => 'newHold')) ?>
    </div>
    <div id="option-template">
        <?php $this->renderPartial('question-option-template', array('option' => null, 'questionName' => 'newHold', 'optionName' => 'newOpHold')) ?>
    </div>
</div>

<form method="post" id="survey-form">
    <?php echo CHtml::hiddenField('survey_id', $surveyId)?>
    <div class="container">
        
        <?php 
            if ($businessList) {
        ?>
        <div class="row">
            Business:<br><?php echo CHtml::dropDownList('business_id', '', CHtml::listData($businessList, 'business_id', 'business_name')) ?>
        </div>
        <?php
            }
        ?>
        
        <div class="row form-row">
            <?php echo CHtml::textField('survey_name', $surveyName, array('placeholder' => 'Survey Name'))?>
        </div>
        
        
        <div class="row form-row">
            <div class="container" id="question-list">
            <?php 
                $count = 0;
                foreach($surveyQuestions as $q) {
                    $this->renderPartial('question-template', array(
                        'question' => $q, 
                        'questionName' => 'oldQuestion'.$count, 
                        'questionTypes' => $questionTypes,
                        'isTemplate' => $isTemplate,
                    ));
                    $count++;
                }
            ?>
            </div>
        </div>
    
        <div class="row form-row">

            <a href="#" class="btn btn-primary btn-md" id="add-question">Add Question</a>

        </div>
        
        <div class="row form-row">
            <a href="#" class="btn btn-primary btn-lg submit-btn">save</a>
        </div>
    </div>
    
</form>



<?php

//$baseUrl = $this->createAbsoluteUrl('/');
//$showlistingUrl = $baseUrl.'/package/package/showlisting';

$script = <<<EOD

// /////////////////////////////////////////////////////////////////////////////
// Survey Form
// /////////////////////////////////////////////////////////////////////////////
    
    var newIndex = 0;
        
    function questionTypeChange(e) {
        var target = $(e.target);
        if(target.val() == 2) {
            target.parent().parent().parent().find('.question-options').show();
        }
        else {
            target.parent().parent().parent().find('.question-options').hide();
        }
    }
        
    function addOption(e) {
        var target = $(e.target);
        var newOption = $($('#option-template').html().replace(/newHold/g, target.attr('data-question')).replace(/newOpHold/g, 'newOption' + newIndex));
        target.parent().parent().find('.option-list').append(newOption);
        newIndex++;
        return false;
    }
        
    function deleteItem(e) {
        $(e.target).parent().parent().parent().remove();
        return false;
    }
        
    function moveUp(e) {
        var tgt = $(e.target).parent().parent().parent();
        var prev = tgt.prev();
        prev.before(tgt);
        return false;
    }
        
    function moveDown(e) {
        var tgt = $(e.target).parent().parent().parent();
        var next = tgt.next();
        next.after(tgt);
        return false;
    }
        
    function initActions(tgt) {
        tgt.find('.question-type-field').change(questionTypeChange);
        tgt.find('.add-option').click(addOption);
        tgt.find('.delete').click(deleteItem);
        tgt.find('.up').click(moveUp);
        tgt.find('.down').click(moveDown);
    }
        
    function addQuestion() {
        var newQuestion = $($('#question-template').html().replace(/newHold/g, 'newQuestion' + newIndex));
        $('#question-list').append(newQuestion);
        initActions(newQuestion);
        newIndex++;
    }
        
    $('#add-question').click(function() {
        addQuestion();
        return false;
    });
        
    $('.submit-btn').click(function() {
        $('#survey-form').submit();
        return false;
    });
        
    initActions($('#survey-form'));

EOD;

Yii::app()->clientScript->registerScript('biz_listing', $script, CClientScript::POS_READY);

?>