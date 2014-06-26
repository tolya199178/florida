<?php
    $myMessages = $data['myMessages'];
?>

            <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#allmessages" data-toggle="tab"><span
                            class="glyphicon glyphicon-inbox"> </span>All Messages</a></li>
                    <li><a href="#friendmessages" data-toggle="tab"><span
                            class="glyphicon glyphicon-user"></span> Friend Messages</a></li>
                    <li><a href="#alertmessages" data-toggle="tab"><span
                            class="glyphicon glyphicon-tags"></span> Alerts and Notices</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <!-- Tab contents for all messages -->
                    <div class="tab-pane fade in active" id="allmessages">

                        <div class="list-group">

                              <div class="table-responsive" style="height:300px;overflow-y:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2">From</th>
                                                <th class="col-sm-1">Message Type</th>
                                                <th class="col-sm-7">Message Details</th>
                                                <th class="col-sm-2">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <tr>
                                                <td><?php echo CHtml::encode($itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name); ?></td>

                                                <td>
                                                    <?php if ($itemMessage->message_category == 'Notice' ) { ?>
                                                        <span class="badge badge-warning"><?php echo CHtml::encode($itemMessage->message_category); ?></span>
                                                    <?php } ?>
                                                    <?php if ($itemMessage->message_category == 'Alert' ) { ?>
                                                        <span class="badge badge-error"><?php echo CHtml::encode($itemMessage->message_category); ?></span>
                                                    <?php } ?>
                                                    <?php if ($itemMessage->message_category == 'Event' ) { ?>
                                                        <span class="badge badge-info"><?php echo CHtml::encode($itemMessage->message_category); ?></span>
                                                    <?php } ?>

                                                </td>

                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo CHtml::encode($itemMessage->subject); ?>
                                                   </a>
                                                </td>

                                                <td><?php echo CHtml::encode($itemMessage->sent); ?></td>
                                            </tr>
                                         <?php } ?>

                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                    <!-- ./Tab contents for all messages -->

                    <!-- Tab contents for friend messages -->
                    <div class="tab-pane fade in" id="friendmessages">
                        <div class="list-group">
                              <div class="table-responsive" style="height:300px;overflow-y:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2">From</th>
                                                <th class="col-sm-8">Message Details</th>
                                                <th class="col-sm-2">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <?php
                                                    if (!empty($itemMessage->message_category) )
                                                    {
                                                        continue;
                                                    }
                                            ?>

                                            <tr>
                                                <td><?php echo CHtml::encode($itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name); ?></td>

                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo CHtml::encode($itemMessage->subject); ?>
                                                   </a>
                                                </td>

                                                <td><?php echo CHtml::encode($itemMessage->sent); ?></td>
                                            </tr>
                                         <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                    <!-- ./Tab contents for friend messages -->

                    <!-- Tab contents for alert and notifications messages -->
                    <div class="tab-pane fade in" id="alertmessages">
                        <div class="list-group">
                              <div class="table-responsive" style="height:300px;overflow-y:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2">From</th>
                                                <th class="col-sm-1">Message Type</th>
                                                <th class="col-sm-7">Message Details</th>
                                                <th class="col-sm-2">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <?php
                                                if (($itemMessage->message_category != 'Notice') && ($itemMessage->message_category != 'Alert') )
                                                {
                                                    continue;
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo CHtml::encode($itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name); ?></td>

                                                <td>
                                                    <?php if ($itemMessage->message_category == 'Notice' ) { ?>
                                                        <span class="badge badge-warning"><?php echo CHtml::encode($itemMessage->message_category); ?></span>
                                                    <?php } ?>
                                                    <?php if ($itemMessage->message_category == 'Alert' ) { ?>
                                                        <span class="badge badge-error"><?php echo CHtml::encode($itemMessage->message_category); ?></span>
                                                    <?php } ?>
                                                    <?php if ($itemMessage->message_category == 'Event' ) { ?>
                                                        <span class="badge badge-info"><?php echo CHtml::encode($itemMessage->message_category); ?></span>
                                                    <?php } ?>

                                                </td>

                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo CHtml::encode($itemMessage->subject); ?>
                                                   </a>
                                                </td>

                                                <td><?php echo CHtml::encode($itemMessage->sent); ?></td>
                                            </tr>
                                         <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                    <!-- ./Tab contents for alert and notifications messages -->


                </div>
                <!-- ./Tab panes -->

                <hr style="height: 12px; border: 0; box-shadow: inset 0 12px 12px -12px rgba(0,0,0,0.5);" />

                <!-- Message Preview -->
                <div class='row' style="height:300px;">

                    <div class="col-sm-12">

                    </div>

                </div>
                <!-- Message Preview -->