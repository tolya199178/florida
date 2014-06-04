<?php

$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/css/dialogue/dialogue.css');

?>
<?php

// $this->title = $modelQuestion->title;

$answerOrders = array(
    'Active' => 'active',
    'Oldest' => 'oldest',
    'Votes' => 'votes'
);


// Hack attacck
$answerOrder = null;


?>
<div class="container" style="background:#eeeeee;">
    <div class="qa-view row">
        <div class="col-md-12">
            <div class="qa-view-question">
                <div class="qa-view-actions">

<div class="qa-vote">
    <?php if ($modelQuestion->user_id != Yii::app()->user->id) { ?>
    <a class="qa-vote-up"
       href="< ? = Module::url([$route, 'id' => $model->id, 'vote' => 'up']) ? >"
       title="< ? = Module::t('Vote up') ?> ">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
    <?php } ?>
    <span class="qa-vote-count"><?php echo $modelQuestion->votes ?></span>
    <?php if ($modelQuestion->user_id != Yii::app()->user->id) { ?>
    <a class="qa-vote-down"
       href="< ? = Module::url([$route, 'id' => $model->id, 'vote' => 'down']) ? >"
       title="< ? = Module::t('Vote down') ? >">
        <span class="glyphicon glyphicon-chevron-down"></span>
    </a>
    <?php } ?>
</div>
<!--                     < ? = $this->render('parts/favorite', ['model' => $model]) ? > -->

                </div>

                <div class="qa-view-body">
                    <h1 class="qa-view-title"><?php echo CHtml::encode($modelQuestion->title) ?></h1>

                    <div class="qa-view-text">
                        <?php echo CHtml::encode($modelQuestion->content) ?>
                    </div>

                    <div class="qa-view-meta">

<!--                         < ?= $this->render('parts/tags-list', ['model' => $model]) ? > -->
<span class="qa-tags">
<?php $tagsList = explode(",", $modelQuestion->tags); ?>
<?php foreach ($tagsList as $tag) { ?>
   <?php echo CHtml::link($tag, 'index', array('class'=>"label label-primary", 'title'=>"", 'rel'=>"tag")); ?>
<?php } ?>
</span>

<!--                         < ? = $this->render('parts/edit-links', ['model' => $model]) ? > -->
<?php if ($modelQuestion->user_id == Yii::app()->user->id) { ?>
   <?php echo CHtml::link('Edit', 'edit', array('class'=>"label label-success", 'title'=>"")); ?>

   <?php echo CHtml::link('Delete', 'delete', array('class'=>"label label-danger", 'title'=>"")); ?>

       <span class="glyphicon glyphicon-remove"></span></a>
<?php } ?>

<!--                         < ? = $this->render('parts/created', ['model' => $model]) ? > -->
<span class="qa-created">
    <span class="qa-time"><?php echo $modelQuestion->modified_date; ?></span>
    <span class="qa-user"><?php echo $modelQuestion->user['first_name'].' '.$modelQuestion->user['last_name'] ?></span>
</span>
                    </div>
                </div>
            </div>

            <div class="qa-view-answers-heading clearfix">
                <h3 class="qa-view-title">
                    <?php echo  ((count($listAnswers) == 0)?'No Answers yet': ((count($listAnswers) == 1)?'One Answer.': count($listAnswers).' answers.') ); ?>
                </h3>

                <?php if (count($listAnswers)) { ?>
                    <ul class="qa-view-tabs nav nav-tabs">
                        <?php foreach ($listAnswers as $aId => $aOrder) { ?>
                            <li <?php echo ($aOrder == $answerOrder) ? 'class="active"' : '' ?> >
                                <?php echo CHtml::link('Edit', 'edit', array('class'=>"label label-success", 'title'=>"")); ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php }  ?>
            </div>

            <div class="qa-view-answers">
                <?php foreach ($listAnswers as $row) { ?>
                    <div class="qa-view-answer">
                        <div class="qa-view-actions">
<!--                             < ? = $this->render('parts/vote', ['model' => $row, 'route' => 'answer-vote']) ? > -->
<div class="qa-vote">
    <?php if ($row->user_id != Yii::app()->user->id) { ?>
    <a class="qa-vote-up"
       href="< ? = Module::url([$route, 'id' => $model->id, 'vote' => 'up']) ? >"
       title="< ? = Module::t('Vote up') ?> ">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
    <?php } ?>
    <span class="qa-vote-count"><?php echo $row->votes ?></span>
    <?php if ($row->user_id != Yii::app()->user->id) { ?>
    <a class="qa-vote-down"
       href="< ? = Module::url([$route, 'id' => $model->id, 'vote' => 'down']) ? >"
       title="< ? = Module::t('Vote down') ? >">
        <span class="glyphicon glyphicon-chevron-down"></span>
    </a>
    <?php } ?>
</div>

                        </div>
                        <div class="qa-view-body">
                            <div class="qa-view-text">
                                <?php echo CHtml::encode($row->content) ?>
                            </div>

                            <div class="qa-view-meta">
<!--                                 < ? = $this->render('parts/edit-links', ['model' => $row]) ? > -->
<?php if ($row->user_id == Yii::app()->user->id) { ?>
   <?php echo CHtml::link('Edit', 'edit', array('class'=>"label label-success", 'title'=>"")); ?>

   <?php echo CHtml::link('Delete', 'delete', array('class'=>"label label-danger", 'title'=>"")); ?>

       <span class="glyphicon glyphicon-remove"></span></a>
<?php } ?>


<!--                                 < ? = $this->render('parts/created', ['model' => $row]) ? > -->
<span class="qa-created">
    <span class="qa-time"><?php echo $row->modified_date; ?></span>
    <span class="qa-user"><?php echo $row->user['first_name'].' '.$row->user['last_name'] ?></span>
</span>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

            <div class="qa-view-pager">
<!--                 < ? = $this->render('parts/pager', ['dataProvider' => $answerDataProvider]) ? > -->
            </div>

            <div class="qa-view-answer-form">
<!--                 < ? = $this->render('parts/form-answer', ['model' => $answer, 'action' => Module::url(['answer', 'id' => $model->id])]); ? > -->

<?php

$answer = new PostAnswer;

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'focus'=>array($answer,'username'),
)); ?>

<?php echo $form->errorSummary($answer); ?>

<div class="form-group field-answer-content required">
<label for="answer-content" class="control-label"></label>
    <?php echo $form->textArea($answer,'content', array('rows' => 6, 'class' => 'form-control')); ?>
<div class="help-block"></div>
</div>



    <div class="form-group">
	<?php echo CHtml::submitButton(($answer->isNewRecord ? 'Create' : 'Update'), array('class'=>"btn btn-default")); ?>
    </div>

<?php $this->endWidget(); ?>


            </div>


        </div>
    </div>
</div>
