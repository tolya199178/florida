<?php

$myLocalFriends     = $data['listMyFriends']['lstMyFriends'];
$myOnlineFriends    = $data['listMyFriends']['lstMyOnlineFriends'];

?>

<!-- Friends main panel -->

<style type="text/css">

.my_friend_selected  {
    display: block;
}

.invited {border:solid 3px red}

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

<style>

.friend_list {
    height:300px;overflow-y:auto;overflow-x:off;
}

.friend_list li {
    background-clip: padding-box;
    border-radius: 4px;
    list-style-type: none;
    overflow: hidden;
    padding: 1em 0 1em 1em;
}

.friend_list ul li {
    list-style: disc inside none;
    padding-left: 20px;
}

.friend_list h2, .friend_list p {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    margin: 0;
    padding-bottom: 0;
}
.friend_list p, .friend_list h2 {
    width: 360px;
}
.friend_list img, .friend_list h2, .friend_list p {
    float: left;
}
h2 {
    font-size: 32px;
    padding-bottom: 10px;
}

/* */


.friend_list li:hover
{
  background-color: #eff1f9;
  cursor: pointer;
  box-shadow: #bbbbbb;
}
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

                                <ul class="list-group friend_list">
                                <form action="#" role="form" id="frmInviteMyFriends" method="post">



                                <?php foreach ($myLocalFriends as $myFriend) { ?>
                                <?php
                                        if ($myFriend->friend_status !='Approved') {
                                            continue;
                                        }
                                ?>
                                	<li class='myfriend' rel='<?php echo $myFriend->friend['user_id']; ?>'>

                                	   <div class='col-lg-2'>

                                       	   <div class='col-lg-1'>
                                                <input type="checkbox" class="my_friend_selected" id="my_friend_<?php echo $myFriend->friend['user_id']; ?>" name="invitation_list[]"  value="<?php echo $myFriend->friend['user_id']; ?>" />
                                    	   </div>
                                    	   <div class='col-lg-11'>
                                                <?php
                                                if(@GetImageSize(Yii::getPathOfAlias('webroot').'/uploads/images/user/thumbnails/'.$myFriend->friend['image']))
                                                {
                                                    echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/user/thumbnails/'.$myFriend->friend['image'],
                                                                      CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name),
                                                                      array("width"=>"150px" ,"height"=>"150px") );
                                                }
                                                else
                                                {
                                                    echo CHtml::image(Yii::app()->theme->baseUrl .'/resources/images/site/no-image.jpg',
                                                        CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']),
                                                        array("width"=>"150px" ,"height"=>"150px") );
                                                }
                                                ?>
                                    	   </div>



                                	   </div>

                                	   <div class='col-lg-5'>
                                    		<h2><a href="#">
                                    		      <?php echo CHtml::encode($myFriend->friend['first_name']).' '.CHtml::encode($myFriend->friend['last_name']); ?>
                                    		</a></h2>
                                    		<p><span><strong>Joined:</strong>&nbsp;</span><span><?php echo CHtml::encode($myFriend->friend['created_time']); ?><span></span></span></p>
                                    		<p><span><strong>Date of Birth:</strong>&nbsp;</span><span><?php echo CHtml::encode($myFriend->friend['date_of_birth']); ?><span></span></span></p>
                                    		<p><span><strong>Location:</strong>&nbsp;</span><span><?php echo CHtml::encode($myFriend->friend['hometown']); ?><span></span></span></p>

<?php                                       if ($myFriend->friend['login_status'] == 'logged in') { ?>
                                    		    <p>&nbsp;</p>
                                    		    <p><span class="label label-success">Online</span></p>
                                    		<?php } ?>
                                	   </div>

                                	   <div class='col-lg-5'>

                                            <a class="btn btn-md btn-primary" href="<?php echo Yii::app()->createUrl('webuser/sendfriendmessage/'); ?>">
                                                <i class="glyphicon glyphicon-envelope"></i>
                                                Send Message
                                            </a>

                                            <a class="btn btn-md btn-danger" href="<?php echo Yii::app()->createUrl('webuser/blockuser/'); ?>">
                                                <i class="glyphicon glyphicon-minus-sign"></i>
                                                Block User
                                            </a>

                                	   </div>
                                	</li>

                                <?php } ?>
                                </form>
                                </ul>

                            </div>
                            <div class="panel-footer">
                                <button type='submit' class="btn btn-md btn-primary" href="<?php echo Yii::app()->createUrl('webuser/sendfriendmessages/'); ?>" id='send_messages'>
                                    <i class="glyphicon glyphicon-envelope"></i>
                                    Send Message to Selected
                                </button>
                            </div>

                        </div>


<?php

$baseUrl = $this->createAbsoluteUrl('/');


$script = <<<EOD

    $('body').on('click', '.myfriend', function(event) {

        var $$          = $(this)
        var user_id     = $(this).attr('rel');

        if( !$$.is('.invited')){
            $$.addClass('invited');
            $('#my_friend_'+user_id).prop('checked', true);
        } else {
            $$.removeClass('invited');
            $('#my_friend_'+user_id).prop('checked', false);

        }
    })

    $('body').on('click', '#send_messages', function(event) {

    debugger;

        $('#frmInviteMyFriends').submit();

    })

//     // Submit the modal form and close the modal
//     $('body').on('submit', '#frmInviteMyFriends', function(event) {



//         event.preventDefault();

//             debugger;

//         var form_values = $(this).serialize();

//         var url = '$baseUrl/concierge/sendfriendinvitations/';

//         $.ajax({
//                type: "POST",
//                url: url,
//                data: $(this).serialize(),
//                success: function(data)
//                {
//                     $('#modalInviteMyFriends').modal('hide');
//                }
//         });

//         return false; // avoid to execute the actual submit of the form.
//     });

EOD;

Yii::app()->clientScript->registerScript('my_friend_list', $script, CClientScript::POS_READY);

?>