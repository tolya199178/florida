<?php

$baseScriptUrl = $this->createAbsoluteUrl('/');
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/css/dialogue/dialogue.css');

return;

?>


<div class="qa-list list-group">
    <?php if (!empty($listQuestions)) {
            foreach ($listQuestions as $itemQuestion) { ?>
        <div class="qa-item list-group-item clearfix" id="question-< ? php echo $itemQuestion->id ? >">
            <div class="qa-panels">
                <div class="qa-panel votes">
                    <div class="mini-counts"><?php echo $itemQuestion->votes ?></div>
                    <div>votes</div>
                </div>
                <div class="qa-panel status-unanswered">
                    <div class="mini-counts"><?php echo $itemQuestion->answers ?></div>
                    <div>answers</div>
                </div>
                <div class="qa-panel views">
                    <div class="mini-counts"><?php echo $itemQuestion->views; ?></div>
                    <div>views</div>
                </div>
            </div>
            <div class="qa-summary">
                <h4 class="question-heading list-group-item-heading">
                    <?php echo CHtml::link(CHtml::encode($itemQuestion->title),
                                            Yii::app()->createUrl('/dialogue/post/view', array('question' => $itemQuestion->id)),
                                            array('class'=>"question-link", 'title'=>"")); ?>
                </h4>
                <div class="question-meta">

<?php if ($itemQuestion->user_id == Yii::app()->user->id) { ?>
   <?php echo CHtml::link('Edit', 'edit', array('class'=>"label label-success", 'title'=>"")); ?>

   <?php echo CHtml::link('Delete', 'delete', array('class'=>"label label-danger", 'title'=>"")); ?>

       <span class="glyphicon glyphicon-remove"></span></a>
<?php } ?>

                </div>
                <div class="question-tags">
<span class="qa-tags">
<?php $tagsList = explode(",", $itemQuestion->tags); ?>
<?php foreach ($tagsList as $tag): ?>
   <?php echo CHtml::link($tag, 'index', array('class'=>"label label-primary", 'title'=>"", 'rel'=>"tag")); ?>
<?php endforeach; ?>
</span>
                </div>
            </div>
        </div>
<?php   }
     }
     else { ?>
        <div class="qa-item-not-found list-group-item">
            <h4 class="question-heading list-group-item-heading">No results found</h4>
        </div>
    <?php } ?>
</div>