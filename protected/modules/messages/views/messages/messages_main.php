<style>
<!--
#inbox {
	background: #fff;
}
-->
</style>

<style>


.badge {
  padding: 1px 9px 2px;
  font-size: 12.025px;
  font-weight: bold;
  white-space: nowrap;
  color: #ffffff;
  background-color: #999999;
  -webkit-border-radius: 9px;
  -moz-border-radius: 9px;
  border-radius: 9px;
}
.badge:hover {
  color: #ffffff;
  text-decoration: none;
  cursor: pointer;
}
.badge-error {
  background-color: #b94a48;
}
.badge-error:hover {
  background-color: #953b39;
}
.badge-warning {
  background-color: #f89406;
}
.badge-warning:hover {
  background-color: #c67605;
}
.badge-success {
  background-color: #468847;
}
.badge-success:hover {
  background-color: #356635;
}
.badge-info {
  background-color: #3a87ad;
}
.badge-info:hover {
  background-color: #2d6987;
}
.badge-inverse {
  background-color: #333333;
}
.badge-inverse:hover {
  background-color: #1a1a1a;
}
</style>

<div id="inbox">

    <div class="container">

        <p>&nbsp;</p>

        <!-- Message menu bar -->

        <div class="row">
            <!--         <div class="col-sm-3 col-md-2"> -->
            <!--             <div class="btn-group"> -->
            <!--                 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> -->
            <!--                     Mail <span class="caret"></span> -->
            <!--                 </button> -->
            <!--                 <ul class="dropdown-menu" role="menu"> -->
            <!--                     <li><a href="#">Mail</a></li> -->
            <!--                     <li><a href="#">Contacts</a></li> -->
            <!--                     <li><a href="#">Tasks</a></li> -->
            <!--                 </ul> -->
            <!--             </div> -->
            <!--         </div> -->

            <div class="col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2">
                <!-- Split button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default">
                        <div class="checkbox" style="margin: 0;">
                            <label> <input type="checkbox">
                            </label>
                        </div>
                    </button>
                    <button type="button"
                        class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown">
                        <span class="caret"></span><span class="sr-only">Toggle
                            Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">All</a></li>
                        <li><a href="#">Read</a></li>
                        <li><a href="#">Unread</a></li>
                    </ul>
                </div>

                <button type="button" class="btn btn-default"
                    data-toggle="tooltip" title="Refresh">
                    <span class="glyphicon glyphicon-refresh"></span>
                </button>

                <div class="btn-group">
                    <a class="btn btn-md btn-success"
                        href="<?php echo Yii::app()->createUrl('messages/messages/create'); ?>">
                        <i class="glyphicon glyphicon-plus-sign"></i> New Message
                    </a>
                </div>

                <div class="pull-right">
                    <span class="text-muted"><b>1</b>–<b>50</b> of <b>277</b></span>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
        <!-- ./Message menu bar -->

        <hr />

        <!-- Main message area -->
        <div class="row">

            <!--  Message Buckets -->
            <div class="col-sm-3 col-md-2">

                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#">
                        <span class="badge pull-right"><?php echo $myMessagesSummary['Inbox']['N']; ?></span> Inbox </a></li>
                    <li><a href="#">Sent Mail</a></li>
                    <li><a href="#">Archive</a></li>
                    <li><a href="#">
                    <?php if ($myMessagesSummary['Pending Delete']['total'] != 0) { ?>
                        <span class="badge pull-right alert-danger">
                        <?php echo $myMessagesSummary['Pending Delete']['total']; ?>
                        </span>
                    <?php } ?>

                        Pending Delete </a></li>

                </ul>
            </div>
            <!--  ./Message Buckets -->

            <!--  Message Lists -->
            <div class="col-sm-9 col-md-10">

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

            </div>

        </div>
        <!-- ./Main message area -->


    </div>


</div>

