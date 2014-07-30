<style type="text/css">
    #survey {
        background: #ffffff;
    }
</style>

<div id="survey">
    <div class="container">
        <h1>Create new survey</h1>
        <div id="survey-form-container">
            <?php 
                $this->renderPartial('survey-form', array(
                    'questionTypes' => $questionTypes, 
                    'businessList' => $businessList, 
                    'survey' => $survey,
                    'isTemplate' => $isTemplate,
                ));
            ?>
        </div>
    </div>
</div>