<style type="text/css">
    #survey{
        background: #ffffff;
    }
</style>

<div id="survey">
    <div class="container">
        <h1>Surveys</h1>
        <div id="survey-list">
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Business</th>
                    <th>Responses</th>
                    <th></th>
                </tr>
                <?php
                    foreach($surveyList as $survey) {
                ?>
                <tr>
                    <td><?php echo CHtml::encode($survey->survey_name); ?></td>
                    <td><?php echo CHtml::encode($survey->business->business_name); ?></td>
                    <td></td>
                    <td>
                        <a href="<?php echo $this->createUrl('survey/edit/id/' . $survey->survey_id)?>" class="btn btn-primary btn-xs">Edit</a>
                        <a href="#" class="btn btn-warning btn-xs delete" data-id="<?php echo $survey->survey_id?>">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        <div>
            <a href="<?php echo $this->createUrl('survey/edit')?>" class="btn btn-primary btn-sm">Create New Empty Survey</a>
        </div>
        <div>
            <a href="#" class="btn btn-primary btn-sm from-template">Create New From Template</a>
            <?php echo CHtml::dropDownList('template_id', '', CHtml::listData($templateList, 'survey_id', 'survey_name'))?>
        </div>
    </div>
</div>



<?php

$baseUrl = $this->createAbsoluteUrl('/');
$deleteUrl = $baseUrl.'/survey/survey/delete';
$templateUrl = $baseUrl.'/survey/survey/edit/template_id/';

$script = <<<EOD

    $('#survey-list .delete').click(function(e) {
        var confirmDelete = confirm('Do you realy want to delete this survey?');
        if(confirmDelete == true) {
            var data = {survey_id: $(e.target).attr('data-id')};
            $.post('$deleteUrl', data, function() {
                location.reload(true);
            });
        }
        return false;
    });

    $('.from-template').click(function() {
        var url = '$templateUrl' + $('#template_id').val();
        window.location = url;
        return false;
    });

EOD;

Yii::app()->clientScript->registerScript('biz_listing', $script, CClientScript::POS_READY);

?>