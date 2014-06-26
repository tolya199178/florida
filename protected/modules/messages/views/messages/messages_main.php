<style>
<!--
#inbox {
	background: #fff;
}
-->
</style>

<style>
<!--
/* .nav-tabs .glyphicon:not (.no-margin ) { */
/* 	margin-right: 10px; */
/* } */

/* .tab-pane .list-group-item:first-child { */
/* 	border-top-right-radius: 0px; */
/* 	border-top-left-radius: 0px; */
/* } */

/* .tab-pane .list-group-item:last-child { */
/* 	border-bottom-right-radius: 0px; */
/* 	border-bottom-left-radius: 0px; */
/* } */

/* .tab-pane .list-group .checkbox { */
/* 	display: inline-block; */
/* 	margin: 0px; */
/* } */

/* .tab-pane .list-group input[type="checkbox"] { */
/* 	margin-top: 2px; */
/* } */

/* .tab-pane .list-group .glyphicon { */
/* 	margin-right: 5px; */
/* } */

/* .tab-pane .list-group .glyphicon:hover { */
/* 	color: #FFBC00; */
/* } */

/* a.list-group-item.read { */
/* 	color: #222; */
/* 	background-color: #F3F3F3; */
/* } */

/* hr { */
/* 	margin-top: 5px; */
/* 	margin-bottom: 10px; */
/* } */

/* .nav-pills>li>a { */
/* 	padding: 5px 10px; */
/* } */
-->
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
                <a href="#" class="btn btn-danger btn-sm btn-block"
                    role="button">COMPOSE</a>
                <hr />
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#">
                        <span class="badge pull-right">42</span> Inbox </a></li>
                    <li><a href="#">Sent Mail</a></li>
                    <li><a href="#">Archive</a></li>
                    <li><a href="#">Pending Delete</a></li>
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
                            class="glyphicon glyphicon-tags"></span> Alerts and Notifications</a></li>
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
                                                <th class="col-sm-4">From</th>
                                                <th class="col-sm-5">Message Details</th>
                                                <th class="col-sm-2">Date</th>
                                                <th class="col-sm-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <tr>
                                                <td><?php echo CHtml::encode($itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name); ?></td>

                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo CHtml::encode($itemMessage->subject); ?>
                                                   </a>
                                                </td>

                                                <td><?php echo CHtml::encode($itemMessage->sent); ?></td>
                                                <td></td>
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
                                                <th class="col-sm-4">From</th>
                                                <th class="col-sm-5">Message Details</th>
                                                <th class="col-sm-2">Date</th>
                                                <th class="col-sm-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <tr>
                                                <td><?php echo CHtml::encode($itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name); ?></td>

                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo CHtml::encode($itemMessage->subject); ?>
                                                   </a>
                                                </td>

                                                <td><?php echo CHtml::encode($itemMessage->sent); ?></td>
                                                <td></td>
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
                                                <th class="col-sm-4">From</th>
                                                <th class="col-sm-5">Message Details</th>
                                                <th class="col-sm-2">Date</th>
                                                <th class="col-sm-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <tr>
                                                <td><?php echo CHtml::encode($itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name); ?></td>

                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo CHtml::encode($itemMessage->subject); ?>
                                                   </a>
                                                </td>

                                                <td><?php echo CHtml::encode($itemMessage->sent); ?></td>
                                                <td></td>
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


            </div>

        </div>
        <!-- ./Main message area -->


    </div>


</div>

