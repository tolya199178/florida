<?php 

$optionId = 0;
$questionId = 0;
$optionText = '';

if($option) {
    $optionId = $isTemplate ? 0 : $option->survey_question_option_id;
    $optionText = $option->value;
}

?>

<div class="row option">
    <div class="container">
        <div class="row">
            <?php echo CHtml::hiddenField('questions[' . $questionName . '][options][' . $optionName . '][option_id]', $optionId)?>
            <?php echo CHtml::textField('questions[' . $questionName . '][options][' . $optionName . '][option]', $optionText, array('placeholder' => 'option', 'class' => 'option-field'))?>
            <a href="#" class="btn btn-primary btn-sm glyphicon glyphicon-chevron-up up"></a>
            <a href="#" class="btn btn-primary btn-sm glyphicon glyphicon-chevron-down down"></a>
            <a href="#" class="btn btn-danger btn-sm glyphicon glyphicon-remove delete"></a>
        </div>
    </div>
</div>