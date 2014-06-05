                    <h1 class="qa-view-title"><?php echo CHtml::encode($model->title) ?></h1>

                    <div id='<?php echo $type.'_text_'.$model->id; ?>'>

                        <div class="qa-view-text">
                            <?php echo CHtml::encode($model->content) ?>
                        </div>

                        <div class="qa-view-meta" >
                            <?php $this->renderPartial("subviews/tags",array('model' => $model, 'type' => $type)); ?>

                            <?php if ($model->user_id == Yii::app()->user->id) { ?>

                                <?php echo CHtml::link('Edit', Yii::app()->createUrl('//dialogue/post/editpost/',array($type=> $model->id)),
                                                        array('posttype'=>$type, ' class'=>"editpost label label-success",
                                                              'title'=>"", 'target'=> $type.'_text_'.$model->id)); ?>

                                <?php echo CHtml::link('Delete', 'delete', array('class'=>"label label-danger", 'title'=>"")); ?>

    <!--                             <span class="glyphicon glyphicon-remove"></span> -->

                            <?php } ?>

                            <span class="qa-created">
                                <span class="qa-time"><?php echo $model->modified_date; ?></span>
                                <span class="qa-user"><?php echo $model->user['first_name'].' '.$model->user['last_name'] ?></span>
                            </span>

                        </div>
                    </div>

