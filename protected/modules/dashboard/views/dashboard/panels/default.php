<?php

$myMessages         = $data['listMyMessages'];
$mySavedSearch      = $data['mySavedSearch'];
$myPhotos           = $data['myPhotos'];

?>
                    <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#messages" data-toggle="tab">Messages</a></li>
                            <li><a href="#qanda" data-toggle="tab">Q and A</a></li>
                            <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
                            <li><a href="#searches" data-toggle="tab">Saved Searches</a></li>
                            <li><a href="#myphotos" data-toggle="tab">My Photos</a></li>

                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane" id="qanda">
                                <div class="table-responsive">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4 text-center">
                                            <ul class="pagination" id="myPager"></ul>
                                        </div>
                                    </div>
                                </div>
                                <!--/table-resp-->

                                <hr>
                                <h4>Recent Activity</h4>
                                <div class="table-responsive">

                                </div>
                            </div>

                            <!--/tab-pane-->


                            <div class="tab-pane active" id="messages">

                                <?php $this->renderPartial('components/messages', array('myMessages' => $myMessages)) ?>

                            </div>
                            <!--/tab-pane-->

                            <!--tab-pane-->
                            <div class="tab-pane" id="searches">

                                <?php $this->renderPartial('components/mysearches', array('mySavedSearch' => $mySavedSearch)) ?>

                            </div>
                            <!--/tab-pane-->

                            <!--tab-pane-->
                            <div class="tab-pane" id="searches">

                                <?php $this->renderPartial('components/myphotos', array('myPhotos' => $myPhotos)) ?>

                            </div>
                            <!--/tab-pane-->

                            <div class="tab-pane" id="reviews">
                                <hr>

                            </div>
                        </div>
                        <!--/tab-pane-->