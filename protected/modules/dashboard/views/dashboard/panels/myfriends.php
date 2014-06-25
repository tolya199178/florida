
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#myfriendstab" data-toggle="tab">My friends</a></li>
                                <li><a href="#pendingfriendrequesttab" data-toggle="tab">Pending Friend Requests</a></li>
                                <li><a href="#incomingfriendrequesttab" data-toggle="tab">Friend Requests Received</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="myfriendstab">

                                    <?php $this->renderPartial('components/allfriends', array('data' => $data)); ?>

                                </div>
                                <div class="tab-pane" id="pendingfriendrequesttab">

                                    <?php $this->renderPartial('components/friend_requests_sent', array('data' => $data)); ?>

                                </div>
                                <div class="tab-pane" id="incomingfriendrequesttab">

                                    <?php $this->renderPartial('components/friend_requests_received', array('data' => $data)); ?>

                                </div>
                            </div>

