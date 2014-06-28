
                        <!-- Messagebox summary component -->

                        <div class="panel panel-default">
                            <div class="panel-heading">My Messages</div>
                            <div class="panel-body">

                                <a href="<?php echo Yii::app()->createUrl('/messages/'); ?>"
                                    <span class="pull-left">
                                        <strong>You have <?php echo (int) $myInboxCount; ?> unread messages</strong>
                                    </span>
                                </a>

                                <a href="<?php echo Yii::app()->createUrl('/messages/'); ?>"
                                    <button class="btn btn-sm btn-primary pull-right" type="button">
                                      Inbox <span class="badge"><?php echo (int) $myInboxCount; ?></span>
                                    </button>
                                </a>


                            </div>
                        </div>

                        <!-- ./Messagebox summary component -->
