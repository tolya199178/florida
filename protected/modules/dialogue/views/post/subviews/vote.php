<div class="qa-vote">
<?php

// print_r($model->attributes);
// echo "aaa".Yii::app()->user->id;
?>
<?php if ((!Yii::app()->user->isGuest) && ($model->user_id != Yii::app()->user->id)) { ?>
    <a class="qa-vote-up"
       href="<?php echo Yii::app()->createUrl('//dialogue/post/voteup/', array($type => $model->id)); ?>"
       title="Vote up" posttype='<?php echo $type; ?>'  target="<?php echo 'votecount_'.$type.'_'.$model->id; ?>">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
<?php } ?>
    <span class="qa-vote-count" id="<?php echo 'votecount_'.$type.'_'.$model->id; ?>"><?php echo $model->votes ?></span>
<?php if ((!Yii::app()->user->isGuest) && ($model->user_id != Yii::app()->user->id)) { ?>
    <a class="qa-vote-down"
       href="<?php echo Yii::app()->createUrl('//dialogue/post/votedown/', array($type => $model->id)); ?>"
       title="Vote down" posttype='<?php echo $type; ?>'  target="<?php echo 'votecount_'.$type.'_'.$model->id; ?>">
        <span class="glyphicon glyphicon-chevron-down"></span>
    </a>
<?php } ?>
</div>