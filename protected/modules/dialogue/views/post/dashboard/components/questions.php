<?php


    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);

?>

        <div class='row'>

            <?php

                $question = new PostQuestion;

                $form=$this->beginWidget('CActiveForm', array(
                	'id'=>'profile-form',
                    'action'=>Yii::app()->createUrl('//dialogue/post/question/'),
                ));
            ?>

            <div class="col-sm-7">

                <?php echo $form->textArea($question,'content',array(
                                                                    'id'=>'questiontext',
                                                                    'class'=>'form-control',
                                                                    'rows'=>1, 'cols'=>100,
                                                                    'placeholder'=>'What would you like to ask today ???'));
                ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->dropDownList($question,
                                               'category_id',
                                               CHtml::listData(Category::model()->findAll(),'category_id', 'category_name'),
                                               array('id'=>'questiontext',
                                                     'class'=>'form-control',
                                                     'empty' => '(Select a category)',
                                                     'placeholder'=>'(Select a category)')
                                  );
                ?>

                <?php echo $form->textField($question,'tags',array(
                                                                'id'=>'question_tags',
                                                                'class'=>'form-control',
                                                                'placeholder'=>'choose tags'));
                ?>
            </div>
            <div class="col-sm-2">
                <?php echo CHtml::checkBox('PostQuestion[notify_updates]', false, array('id'=>'notify_updates', 'class'=>'')); ?> Notify me of updates.

                <?php echo CHtml::submitButton(($question->isNewRecord ? 'Ask' : 'Update'), array('class'=>"form-control btn btn-primary")); ?>
            </div>

            <?php $this->endWidget(); ?>


        </div>

        <div class='row'>
            <?php $this->renderPartial("list",array('data' => $data)); ?>
        </div>



<?php

$baseUrl = $this->createAbsoluteUrl('/');

$tagListUrl = $baseUrl.'/dialogue/post/autocompletetaglist/';


$script = <<<EOD

    $('#questiontext').focus(function () {
        $(this).animate({ height: "6em" }, 500);
    });

$("#question_tags").select2({
  tags: true,
  tokenSeparators: [",", " "],
  createSearchChoice: function(term, data) {
    if ($(data).filter(function() {
      return this.text.localeCompare(term) === 0;
    }).length === 0) {
      return {
        id: term,
        text: term
      };
    }
  },
  multiple: true,
  ajax: {
    url: '{$tagListUrl}',
    dataType: "json",
    data: function(term, page) {
      return {
        query: term
      };
    },
    results: function(data, page) {
      return {
        results: data
      };
    }
  }
});

//         $("#question_tags").select2({
//  multiple: true,
// //             formatResult: format,
// //             formatSelection: format,
// //             escapeMarkup: function(m) { return m; },
//             ajax: {
//                 url: "{$tagListUrl}",
//                 dataType: 'json',
//                 data: function (term) {
//                     return {
//                         query: term, // search term
//                         page_limit: 10
//                     };
//                 },
//                 results: function (data) {
//                     return {results: data, text:'City'};

//                 }
//             },
//         })


EOD;

Yii::app()->clientScript->registerScript('question_scripts', $script, CClientScript::POS_READY);

?>
