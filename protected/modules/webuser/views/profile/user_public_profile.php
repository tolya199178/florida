<style>
<!--
#dashboard {
    background:#fff;
}

.page_views_count
{
    font-size:100px;
    text-align:center;
}

.banner_views_count
{
    font-size:100px;
    text-align:center;
    color:purple;
}


-->
</style>

        <div id="dashboard">

            <div class="container">
                <div class="row">
                    <div class="col-sm-10">
                        <h1>User Profile : <?php echo CHtml::encode($userModel->first_name).' '.CHtml::encode($userModel->last_name); ?>
                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>

                <div class='row'>
                    <div class="col-sm-12">
                        <div id="statusMsg">
                        <?php if(Yii::app()->user->hasFlash('success')):?>
                            <div class="flash-success">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(Yii::app()->user->hasFlash('error')):?>
                            <div class="flash-error">
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">

    					<div class="row">
        					<div class="col-xs-7 col-sm-12">
                               <a href="#" class='thumbnail'>
<?php
                                    if (!empty($userModel->attributes['image']))
                                    {
                                        if(filter_var($userModel->attributes['image'], FILTER_VALIDATE_URL))
                                        {
                                            $imageURL = $userModel->attributes['image'];
                                        }
                                        else
                                        {
                                            if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/user/'.$userModel->attributes['image']))
                                            {
                                                $imageURL = Yii::app()->request->baseUrl .'/uploads/images/user/'.$userModel->attributes['image'];
                                            }
                                            else
                                            {
                                                $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                    }
?>
                                <?php echo CHtml::image($imageURL, 'User Image', array("width"=>"200px" ,"height"=>"200px", 'id'=>'user_main_image_view')); ?>
                                </a>
        					</div>

                            <a class="btn btn-md btn-warning" href="<?php echo Yii::app()->createUrl('webuser/account/connect/', array('user_id'=>$userModel->user_id)); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Connect with <?php echo CHtml::encode($userModel->first_name); ?>
                            </a>

        					<div class="col-xs-5 col-sm-12">
        						<h3>General Information</h3>

        						<ul class="profile-details">
        							<li>
        								<div><i class="fa fa-briefcase"></i> full name</div>
        								<?php echo CHtml::encode($userModel->first_name).' '.CHtml::encode($userModel->last_name); ?>
        							</li>

        						</ul>

        						<h3>Contact Information</h3>

        						<ul class="profile-details">
        							<li>
        								<div><i class="fa fa-phone"></i> mobile number</div>
        								<?php echo CHtml::encode($userModel->mobile_number); ?>
        							</li>
        							<li>
        								<div><i class="fa fa-envelope"></i> e-mail</div>
        								<?php echo CHtml::encode($userModel->email); ?>
        							</li>
        						</ul>
        					</div>
        				</div><!--/row-->

                    </div>


                    <!--/col-9-->
                    <div class="col-sm-9">




                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#about" data-toggle="tab"><span
                                        class="glyphicon glyphicon-inbox"> </span>About</a></li>
                                <li><a href="#friends" data-toggle="tab"><span
                                        class="glyphicon glyphicon-user"></span>Friends</a></li>
                                <li><a href="#photos" data-toggle="tab"><span
                                        class="glyphicon glyphicon-tags"></span>Photos</a></li>
                                <li><a href="#events" data-toggle="tab"><span
                                        class="glyphicon glyphicon-tags"></span>Events</a></li>
                                <li><a href="#posts" data-toggle="tab"><span
                                        class="glyphicon glyphicon-tags"></span>Posts</a></li>
                                <li><a href="#trips" data-toggle="tab"><span
                                        class="glyphicon glyphicon-tags"></span>Trips</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <!-- Tab contents for profile details -->
                                <div class="tab-pane fade in active" id="about">
                                        About the user.

                                </div>
                                <!-- ./Tab contents for profile details -->

                                <!-- Tab contents for all friends -->
                                <div class="tab-pane fade in" id="friends">

        							<div class="row">
<?php                               foreach ($lstFriends as $itemFriend) { ?>

                                        <div style="margin-bottom:30px" class="col-sm-2 col-xs-6">

<?php
                                            if (!empty($itemFriend->friend['image']))
                                            {
                                                if(filter_var($itemFriend->friend['image'], FILTER_VALIDATE_URL))
                                                {
                                                    $imageURL = $itemFriend->friend['image'];
                                                }
                                                else
                                                {
                                                    if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/user/'.$itemFriend->friend['image']))
                                                    {
                                                        $imageURL = Yii::app()->request->baseUrl .'/uploads/images/user/'.$itemFriend->friend['image'];
                                                    }
                                                    else
                                                    {
                                                        $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                            }
?>
                                            <?php echo CHtml::image($imageURL, 'User Image', array("width"=>"110px" ,"height"=>"110px", 'id'=>'user_main_image_view', 'class'=>"img-thumbnail")); ?>

								        </div>

<?php                               } ?>
        							</div>

                                </div>
                                <!-- ./Tab contents for all friends -->

                                <!-- Tab contents for all user's photos -->
                                <div class="tab-pane fade in" id="photos">
                                    <div class="photogallery">

                                        <ul class="row">

<?php                                   foreach ($lstPhotos as $itemPhoto) { ?>
                                            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                                                <a href="#">
                                                    <?php echo CHtml::image(Yii::app()->request->baseUrl .'/uploads/images/user/'.$itemPhoto->attributes['path'], 'User Image', array("width"=>"250px" ,"height"=>"250px",
                                                          'id'=>'user_main_image_view', 'class'=>"img-thumbnail img-responsive")); ?>
                                                </a>
                                            </li>
<?php                                   } ?>
                                        </ul>
                                    </div>

                                </div>
                                <!-- ./Tab contents for all user's photos -->


                                <!-- Tab contents for all events -->
                                <div class="tab-pane fade in" id="events">

                                     <!-- Event summary component -->

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            My Events <i class="fa fa-link fa-1x"></i>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                            <?php foreach ($lstEvents as $itemEvent) { ?>
                                                <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/calendar/calendar/details/', array('id' => CHtml::encode($itemEvent->event_id))); ?>"><?php echo $itemEvent->event_title; ?></a></li>
                                            <?php }?>
                                            </ul>

                                        </div>
                                    </div>

                                    <!-- ./Messagebox summary component -->
                                </div>
                                <!-- ./Tab contents for all events -->

                                <!-- Tab contents for all posts -->
                                <div class="tab-pane fade in" id="posts">

                                     <!-- posts summary component -->

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            My Events <i class="fa fa-link fa-1x"></i>
                                        </div>
                                        <div class="panel-body">

                                            <h3>Questions Posted</h3>
                                            <ul class="list-group">
                                            <?php foreach ($lstQuestions as $itemQuestion) { ?>
                                                <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/dialogue/post/view/', array('question' => $itemQuestion->id))?>"><?php echo CHtml::encode($itemQuestion->title); ?></a></li>
                                            <?php }?>
                                            </ul>

                                            <h3>Answers Posted</h3>
                                            <ul class="list-group">
                                            <?php foreach ($lstAnswers as $itemAnswer) { ?>
                                                <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/dialogue/post/view/', array('answer' => $itemAnswer->id))?>"><?php echo substr(CHtml::encode($itemAnswer->content), 0, 50); ?></a></li>
                                            <?php }?>
                                            </ul>

                                        </div>
                                    </div>

                                    <!-- ./posts summary component -->

                                </div>
                                <!-- ./Tab contents for all posts -->

                                <!-- Tab contents for all messages -->
                                <div class="tab-pane fade in" id="trips">

                                    My trips
                                </div>
                                <!-- ./Tab contents for all messages -->


                            </div>
                            <!-- ./Tab panes -->







                </div>
                <!--/col-9-->
            </div>
            <!--/row-->
        </div>

