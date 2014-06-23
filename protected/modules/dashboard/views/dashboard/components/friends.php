<style type="text/css">

.my_friend_selected  {
    display: none;
}
</style>

<style>
<!--
#alphabet-list ul
{
margin: 0;
padding: 0;
list-style-type: none;
text-align: center;
}

#alphabet-list ul li { display: inline; }

#alphabet-list ul li a
{
text-decoration: none;
padding: .1em .1em;
color: #fff;
background-color: #cccccc;
}

#alphabet-list ul li a:hover
{
color: #000;
/* background-color: #369; */
background: #FBF8E9;
font-weight: bold;
}

-->
</style>

<?php

$baseUrl = $this->createAbsoluteUrl('/');


$script = <<<EOD

$(document).on('click', '#alphabet-list > ul > li > a', function(evt) {

 	evt.preventDefault();

 	// Grab the letter that was clicked
 	var sCurrentLetter = $(this).text().toLowerCase();

 	// Now hide all rows that have IDs that do not start with this letter
    $('#friend_list > div').show();
 	$('#friend_list > div:not( [id^="' + sCurrentLetter + '"] )').hide();


});

EOD;

Yii::app()->clientScript->registerScript('friend_list', $script, CClientScript::POS_READY);

?>



                        <div class="panel panel-default">


                            <div class="panel-heading">
                                My Friends <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">

                                <!-- /#alphabet-list -->
                                <div  id="alphabet-list">
                                <ul>
                                	<li><a href="javascript:;">A</a></li>
                                	<li><a href="javascript:;">B</a></li>
                                	<li><a href="javascript:;">C</a></li>
                                	<li><a href="javascript:;">D</a></li>
                                	<li><a href="javascript:;">E</a></li>
                                	<li><a href="javascript:;">F</a></li>
                                	<li><a href="javascript:;">G</a></li>
                                	<li><a href="javascript:;">H</a></li>
                                	<li><a href="javascript:;">I</a></li>
                                	<li><a href="javascript:;">J</a></li>
                                	<li><a href="javascript:;">K</a></li>
                                	<li><a href="javascript:;">L</a></li>
                                	<li><a href="javascript:;">M</a></li>
                                	<li><a href="javascript:;">N</a></li>
                                	<li><a href="javascript:;">O</a></li>
                                	<li><a href="javascript:;">P</a></li>
                                	<li><a href="javascript:;">Q</a></li>
                                	<li><a href="javascript:;">R</a></li>
                                	<li><a href="javascript:;">S</a></li>
                                	<li><a href="javascript:;">T</a></li>
                                	<li><a href="javascript:;">U</a></li>
                                	<li><a href="javascript:;">V</a></li>
                                	<li><a href="javascript:;">W</a></li>
                                	<li><a href="javascript:;">X</a></li>
                                	<li><a href="javascript:;">Y</a></li>
                                	<li><a href="javascript:;">Z</a></li>


                                </ul>
                                </div>
                                <!-- /#alphabet-list -->



                                <ul class="list-group" id='friend_list' style="height:300px;overflow-y:auto;overflow-x:off;">

                                <?php foreach ($myLocalFriends as $myFriend) { ?>
                                <?php
                                        if ($myFriend->friend_status !='Approved') {
                                            continue;
                                        }
                                ?>
                                    <div class='row myfriend' rel='<?php echo CHtml::encode($myFriend->friend['user_id']); ?>' id="<?php echo strtolower($myFriend->friend['first_name']); ?>">
                                        <div class='col-lg-3'>

                                            <?php
                                            if(@GetImageSize(Yii::getPathOfAlias('webroot').'/uploads/images/user/thumbnails/'.$myFriend->friend['image']))
                                            {
                                                echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/user/thumbnails/'.$myFriend->friend['image'],
                                                                  CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name),
                                                                  array("width"=>"50px" ,"height"=>"50px") );
                                            }
                                            else
                                            {
                                                echo CHtml::image(Yii::app()->theme->baseUrl .'/resources/images/site/no-image.jpg',
                                                    CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']),
                                                    array("width"=>"50px" ,"height"=>"50px") );
                                            }
                                            ?>
                                        </div>
                                        <div class='col-lg-9'>
                                            <input type="checkbox" class="my_friend_selected" id="my_friend_<?php echo $myFriend->friend['user_id']; ?>" name="invitation_list[]"  value="<?php echo $myFriend->friend['user_id']; ?>" />
                                            <?php echo CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']); ?>
                                            <br/><?php echo CHtml::encode($myFriend->friend['hometown']); ?>
                                            <?php echo CHtml::link('See '.CHtml::encode($myFriend->friend['first_name']).'\'s profile', Yii::app()->createUrl('/webuser/profile/showfriend', array('friend' => $myFriend->friend['user_id'] )), array('class' => 'result_button_link'));   ?>
                                        </div>
                                    </div>

                                <?php } ?>
                                </ul>

                            </div>

                        </div>

                        <ul class="list-group">
                            <li class="list-group-item text-muted">My Friends List <i
                                class="fa fa-dashboard fa-1x"></i></li>

                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>My Friends</strong>', Yii::app()->createUrl('/dashboard/dashboard/show/component/allfriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['allfriends'], Yii::app()->createUrl('/dashboard/dashboard/show/component/allfriends/')); ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>Friends Online</strong>', Yii::app()->createUrl('/dashboard/dashboard/show/component/onlinefriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['onlinefriends'], Yii::app()->createUrl('/dashboard/dashboard/show/component/onlinefriends/')); ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>Sent Friend Invitations</strong>', Yii::app()->createUrl('/dashboard/dashboard/show/component/onlinefriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['sentfriendrequests'], Yii::app()->createUrl('/dashboard/dashboard/show/component/sentfriendrequests/')); ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <?php echo CHtml::link('<strong>Received Friend Invitations</strong>', Yii::app()->createUrl('/dashboard/dashboard/show/component/onlinefriends/')); ?>
                                </span>
                                <?php echo CHtml::link($myFriendsCount['receivedfriendrequests'], Yii::app()->createUrl('/dashboard/dashboard/show/component/receivedfriendrequests/')); ?>
                            </li>

                            <li class="list-group-item text-center">
                                <a class="btn btn-lg btn-success" href="<?php echo Yii::app()->createUrl('/dashboard/dashboard/show/component/allfriends/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    See all friends
                                </a>
                            </li>
                        </ul>