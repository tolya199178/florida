                            <h3>Inbox</h3>
                             <div class="btn-group">
                                <a class="btn btn-md btn-success"
                                    href="<?php echo Yii::app()->createUrl('messages/messages/create'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i> New Message
                                </a>
                             </div>

                              <div class="table-responsive" style="height:300px;overflow-y:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-5">Subject</th>
                                                <th class="col-sm-4">From</th>
                                                <th class="col-sm-2">Date</th>
                                                <th class="col-sm-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo $this->createUrl('/messages/messages/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo $itemMessage->subject; ?>
                                                   </a>
                                                </td>
                                                <td><?php echo $itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name; ?></td>
                                                <td><?php echo $itemMessage->sent; ?></td>
                                                <td></td>
                                            </tr>
                                         <?php } ?>

                                        </tbody>
                                    </table>
                                </div>

                                <hr style="border:3px double silver;">
                                <h3>Message View</h3>
                                <div id='message_details'>
                                </div>
