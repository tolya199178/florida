<?php

$myMessages         = $data['listMyMessages'];

?>
                    <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#messages" data-toggle="tab">Messages</a></li>
                            <li><a href="#qanda" data-toggle="tab">Q and A</a></li>
                            <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
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

                            <div class="tab-pane" id="reviews">
                                <hr>

                            </div>
                        </div>
                        <!--/tab-pane-->