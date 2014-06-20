<<style>
<!--
#dashboard {
    background:#fff;
}
-->
</style>

        <div id="dashboard">

            <div class="container">
                <div class="row">
                    <div class="col-sm-10">
                        <h1>Dashboard : <?php echo Yii::app()->user->getFullName(); ?>


                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">

                        <div class="container">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                                <li><a href="#preferences" data-toggle="tab">Preferences</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="details">TODO: Details...</div>
                                <div class="tab-pane" id="settings">TODO: Settings...</div>
                                <div class="tab-pane" id="preferences">TODO: Preferences...</div>
                            </div>
                        </div>

                        <p>&nbsp;</p>



                        <!--left col-->
                        <ul class="list-group">
                            <li class="list-group-item text-muted">Profile</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span>
                                2.13.2014</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Last
                                        seen</strong></span> Yesterday</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Real
                                        name</strong></span> Joseph Doe</li>
                        </ul>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Businesses <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($listMyBusiness as $itemBusiness) { ?>
                                    <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/business/profile/', array('id' => $itemBusiness->business_id))?>"><?php echo $itemBusiness->business_name; ?></a></li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-lg btn-success" href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Add a business
                                </a>
                            </div>
                        </div>


                        <ul class="list-group">
                            <li class="list-group-item text-muted">Activity <i
                                class="fa fa-dashboard fa-1x"></i></li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span>
                                125</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span>
                                13</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span>
                                37</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span>
                                78</li>
                        </ul>

                        <div class="panel panel-default">
                            <div class="panel-heading">Social Media</div>
                            <div class="panel-body">
                                <i class="fa fa-facebook fa-2x"></i> <i
                                    class="fa fa-github fa-2x"></i> <i
                                    class="fa fa-twitter fa-2x"></i> <i
                                    class="fa fa-pinterest fa-2x"></i> <i
                                    class="fa fa-google-plus fa-2x"></i>
                            </div>
                        </div>
                    </div>


                    <!--/col-3-->
                    <div class="col-sm-9">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#messages" data-toggle="tab">Messages</a></li>
                            <li><a href="#qanda" data-toggle="tab">Q and A</a></li>
                            <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane" id="qanda">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Label 1</th>
                                                <th>Label 2</th>
                                                <th>Label 3</th>
                                                <th>Label</th>
                                                <th>Label</th>
                                                <th>Label</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                            <tr>
                                                <td>1</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                                <td>Table cell</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td><i class="pull-right fa fa-edit"></i>
                                                    Today, 1:00 - Jeff Manzi liked your
                                                    post.</td>
                                            </tr>
                                            <tr>
                                                <td><i class="pull-right fa fa-edit"></i>
                                                    Today, 12:23 - Mark Friendo liked and
                                                    shared your post.</td>
                                            </tr>
                                            <tr>
                                                <td><i class="pull-right fa fa-edit"></i>
                                                    Today, 12:20 - You posted a new blog
                                                    entry title "Why social media is".</td>
                                            </tr>
                                            <tr>
                                                <td><i class="pull-right fa fa-edit"></i>
                                                    Yesterday - Karen P. liked your post.</td>
                                            </tr>
                                            <tr>
                                                <td><i class="pull-right fa fa-edit"></i> 2
                                                    Days Ago - Philip W. liked your post.</td>
                                            </tr>
                                            <tr>
                                                <td><i class="pull-right fa fa-edit"></i> 2
                                                    Days Ago - Jeff Manzi liked your post.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--/tab-pane-->


                            <div class="tab-pane active" id="messages">

                                <?php $this->renderPartial('components/messages', array('myMessages' => $myMessages)) ?>

                            </div>
                            <!--/tab-pane-->

                            <div class="tab-pane" id="reviews">
                                <hr>
                                <form class="form" action="##" method="post"
                                    id="registrationForm">
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="first_name"><h4>First name</h4></label>
                                            <input class="form-control" name="first_name"
                                                id="first_name" placeholder="first name"
                                                title="enter your first name if any."
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="last_name"><h4>Last name</h4></label>
                                            <input class="form-control" name="last_name"
                                                id="last_name" placeholder="last name"
                                                title="enter your last name if any."
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="phone"><h4>Phone</h4></label> <input
                                                class="form-control" name="phone" id="phone"
                                                placeholder="enter phone"
                                                title="enter your phone number if any."
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="mobile"><h4>Mobile</h4></label> <input
                                                class="form-control" name="mobile"
                                                id="mobile"
                                                placeholder="enter mobile number"
                                                title="enter your mobile number if any."
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="email"><h4>Email</h4></label> <input
                                                class="form-control" name="email" id="email"
                                                placeholder="you@email.com"
                                                title="enter your email." type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="email"><h4>Location</h4></label> <input
                                                class="form-control" id="location"
                                                placeholder="somewhere"
                                                title="enter a location" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="password"><h4>Password</h4></label>
                                            <input class="form-control" name="password"
                                                id="password" placeholder="password"
                                                title="enter your password." type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="password2"><h4>Verify</h4></label> <input
                                                class="form-control" name="password2"
                                                id="password2" placeholder="password2"
                                                title="enter your password2."
                                                type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <br>
                                            <button class="btn btn-lg btn-success"
                                                type="submit">
                                                <i class="glyphicon glyphicon-ok-sign"></i>
                                                Save
                                            </button>
                                            <button class="btn btn-lg" type="reset">
                                                <i class="glyphicon glyphicon-repeat"></i>
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/tab-pane-->
                    </div>
                    <!--/tab-content-->
                </div>
                <!--/col-9-->
            </div>
            <!--/row-->
        </div>

