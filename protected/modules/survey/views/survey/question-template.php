<?php 

$questionId = 0;
$questionType = 1;
$questionText = '';
$questionOptions = array();
$optionsStyle = 'style="display: none"';

if($question) {
    $questionId = $isTemplate ? 0 : $question->survey_question_id;
    $questionText = $question->question;
    $questionType = $question->survey_question_type_id;
    if($questionType == 2) {
        $optionsStyle = '';
    }
    $questionOptions = $question->surveyQuestionOptions;
}

?>

<div class="row question">
    <div class="container">
        <div class="row">
            <?php echo CHtml::hiddenField('questions[' . $questionName . '][question_id]', $questionId)?>
            <?php echo CHtml::dropDownList('questions[' . $questionName . '][question_type]', $questionType, CHtml::listData($questionTypes, 'survey_question_type_id', 'name'), array('class' => 'question-type-field'))?>
            <a href="#" class="btn btn-primary btn-sm glyphicon glyphicon-chevron-up up"></a>
            <a href="#" class="btn btn-primary btn-sm glyphicon glyphicon-chevron-down down"></a>
            <a href="#" class="btn btn-danger btn-sm glyphicon glyphicon-remove delete"></a>
        </div>
        <div class="row">
            <?php echo CHtml::textArea('questions[' . $questionName . '][question]', $questionText, array('placeholder' => 'question', 'class' => 'question-field'))?>
        </div>
        <div class="row question-options" <?php echo $optionsStyle?>>
            <h4>Options</h4>
            <div class="container option-list">
                <?php 
                    $count = 0;
                    foreach($questionOptions as $option) {
                        $this->renderPartial('question-option-template', array(
                            'option' => $option, 
                            'questionName' => $questionName, 
                            'optionName' => 'oldOption' . $count,
                            'isTemplate' => $isTemplate,
                        ));
                        $count++;
                    }
                ?>    
            </div>
            <div>
                <a href="#" class="btn btn-primary btn-xs add-option" data-question="<?php echo $questionName?>">Add Option</a>
            </div>
        </div>
    </div>
</div>