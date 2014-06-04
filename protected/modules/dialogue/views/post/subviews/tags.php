<span class="qa-tags">
<?php
    $tagsList   = explode(",", $model->tags);
    $tagsList   = array_map('trim',$tagsList);
?>
<?php foreach ($tagsList as $tag) { ?>
   <?php echo CHtml::link($tag, Yii::app()->createUrl('//dialogue/post/tagsearch/'.$tag), array('class'=>"label label-primary", 'title'=>"", 'rel'=>"tag")); ?>
<?php } ?>
</span>