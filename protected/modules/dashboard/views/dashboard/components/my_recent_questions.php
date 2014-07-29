                                    <ul class="list-group">
                                        <li class="list-group-item text-muted">My Recent Questions <i
                                            class="fa fa-dashboard fa-1x"></i></li>

<?php                                   foreach ($listMyNewQuestions as $itemQuestion) { ?>
                                            <li class="list-group-item text-right">
                                                <span class="pull-left">
                                                    <?php echo CHtml::link($itemQuestion['title'], Yii::app()->createUrl('/dialogue/post/view/', array('question'=> $itemQuestion['id']))); ?>
                                                </span>
                                                     <?php echo CHtml::encode($itemQuestion['modified_date']); ?>
                                            </li>
<?php                                   } ?>

                                            <li class="list-group-item">
                                                    <a class="btn btn-md btn-warning" href="<?php echo Yii::app()->createUrl('dialogue/'); ?>">
                                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                                        Manage Questions
                                                    </a>
                                            </li>

                                    </ul>