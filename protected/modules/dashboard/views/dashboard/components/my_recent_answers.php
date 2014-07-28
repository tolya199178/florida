                                    <ul class="list-group">
                                        <li class="list-group-item text-muted">My Recent Questions <i
                                            class="fa fa-dashboard fa-1x"></i></li>

<?php                                   foreach ($listMyNewAnswers as $itemAnswer) { ?>
                                            <li class="list-group-item text-right">
                                                <span class="pull-left">
                                                    <?php echo CHtml::link($itemAnswer['title'], Yii::app()->createUrl('/dialogue/post/view/', array('question'=> $itemAnswer['id']))); ?>
                                                </span>
                                                     <?php echo CHtml::encode($itemAnswer['modified_date']); ?>
                                            </li>
<?php                                   } ?>

                                            <li class="list-group-item">
                                                    <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('dialogue/'); ?>">
                                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                                        Manage Answers
                                                    </a>
                                            </li>
                                    </ul>