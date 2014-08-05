                                    <ul class="list-group">
                                        <li class="list-group-item text-muted">Discussions<i
                                            class="fa fa-dashboard fa-1x"></i></li>

<?php                                   foreach ($lstBusinessDiscussions as $itemQuestion) { ?>
                                            <li class="list-group-item text-right">
                                                <span class="pull-left">
                                                    <?php echo CHtml::link($itemQuestion['title'], Yii::app()->createUrl('/dialogue/post/view/', array('question'=> $itemQuestion['id']))); ?>
                                                </span>
                                                     <?php echo CHtml::encode($itemQuestion['modified_date']); ?>
                                            </li>
<?php                                   } ?>

                                    </ul>