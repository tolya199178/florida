<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({
appId:'1465542160344297',
cookie:true,
status:true,
xfbml:true
});

function InviteF()
{
FB.ui({
    method: 'apprequests',
    message: 'Join me at Florida.com',
});
}

</script>


<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery-searchable/dist/jquery.searchable-1.1.0.min.js', CClientScript::POS_END);

?>


<style>

@import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);

.panel > .list-group .list-group-item:first-child {
    /*border-top: 1px solid rgb(204, 204, 204);*/
}

.c-search > .form-control {
   border-radius: 0px;
   border-width: 0px;
   border-bottom-width: 1px;
   font-size: 1.3em;
   padding: 12px 12px;
   height: 44px;
   outline: none !important;
}
.c-search > .form-control:focus {
    outline:0px !important;
    -webkit-appearance:none;
    box-shadow: none;
}
.c-search > .input-group-btn .btn {
   border-radius: 0px;
   border-width: 0px;
   border-left-width: 1px;
   border-bottom-width: 1px;
   height: 44px;
}


.c-list {
    padding: 0px;
    min-height: 44px;
}
.title {
    display: inline-block;
    font-size: 1.7em;
    font-weight: bold;
    padding: 5px 15px;
}
ul.c-controls {
    list-style: none;
    margin: 0px;
    min-height: 44px;
}

ul.c-controls li {
    margin-top: 8px;
    float: left;
}

ul.c-controls li a {
    font-size: 1.7em;
    padding: 11px 10px 6px;
}
ul.c-controls li a i {
    min-width: 24px;
    text-align: center;
}

ul.c-controls li a:hover {
    background-color: rgba(51, 51, 51, 0.2);
}

.c-toggle {
    font-size: 1.7em;
}

.name {
    font-size: 1.7em;
    font-weight: 700;
}

.c-info {
    padding: 5px 10px;
    font-size: 1.25em;
}

</style>


<style>
<!--
.headshot {
    width:100px;
    height:100px'
}

.my_friend_selected  {
    display: none;
}

#contact-list
{
  height:500px;
  overflow-y: auto;
}

-->
</style>

<style>
.invited {
    border:solid 3px red;
    background: #FAE4E4;
}
</style>



 <form action="<?php echo Yii::app()->createUrl('myfriend/myfriend/joinapp/'); ?>" class="form-horizontal"  role="form" id="frmInviteMyFriends" method="post">

<?php /* echo CHtml::beginForm(); */ ?>

            <div class="row">
                <div class="col-sm-6">

 <a href="#try" onclick="InviteF();">
Click Here
</a>

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading c-list">
                                    <span class="title">Contacts</span>

                                    <ul class="pull-right c-controls">
                                        <li><a href="#cant-do-all-the-work-for-you" data-toggle="tooltip" data-placement="top" title="Add Contact"><i class="glyphicon glyphicon-plus"></i></a></li>
                                        <li><a href="#" class="hide-search" data-command="toggle-search" data-toggle="tooltip" data-placement="top" title="Toggle Search"><i class="fa fa-ellipsis-v"></i></a></li>
                                    </ul>
                                </div>

                                <div class="row" style="display: none;">



                                    <div class="col-xs-12">
                                        <div class="input-group c-search">
                                            <input type="text" class="form-control" id="contact-list-search">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search text-muted"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-group" id="contact-list">

                                    <?php foreach ($myLocalFriends as $myFriend) { ?>

                                    <li class="list-group-item myfriend" rel='<?php echo (int) $myFriend->friend['user_id']; ?>'>
                                        <div class="col-xs-12 col-sm-3">

<?php

                                            if (!empty($myFriend->friend['image']))
                                            {
                                                if(filter_var($myFriend->friend['image'], FILTER_VALIDATE_URL))
                                                {
                                                    $imageURL = $myFriend->friend['image'];
                                                }
                                                else
                                                {
                                                    if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$myFriend->friend['image']))
                                                    {
                                                        $imageURL = Yii::app()->request->baseUrl .'/uploads/images/business/'.$myFriend->friend['image'];
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

                                            <img src="<?php echo $imageURL; ?>" alt="<?php echo CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name); ?>" class="img-responsive img-circle headshot" />
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <span class="name"><?php echo CHtml::encode($myFriend->friend->first_name).' '.CHtml::encode($myFriend->friend->last_name); ?></span><br/>
                                            <span class="glyphicon glyphicon-map-marker text-muted c-info" data-toggle="tooltip" title="<?php echo CHtml::encode($myFriend->friend['hometown']); ?>"></span>
                                            <span class="visible-xs"> <span class="text-muted"><?php echo CHtml::encode($myFriend->friend['hometown']); ?></span><br/></span>
                                            <span class="glyphicon glyphicon-earphone text-muted c-info" data-toggle="tooltip" title="<?php echo CHtml::encode($myFriend->friend['mobile_number']); ?>"></span>
                                            <span class="visible-xs"> <span class="text-muted"><?php echo CHtml::encode($myFriend->friend['mobile_number']); ?></span><br/></span>
                                            <span class="fa fa-comments text-muted c-info" data-toggle="tooltip" title="<?php echo CHtml::encode($myFriend->friend['email']); ?>"></span>
                                            <span class="visible-xs"> <span class="text-muted">s<?php echo CHtml::encode($myFriend->friend['email']); ?></span><br/></span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input type="checkbox" class="my_friend_selected" id="my_friend_<?php echo (int) $myFriend->friend['user_id']; ?>" name="invitation_list[]"  value="<?php echo (int) $myFriend->friend['facebook_id']; ?>" />

                                    </li>
<?php                               } ?>
                                </ul>

                                <div class="panel-footer">

                                        <div class="row submit">
                                            <?php echo CHtml::submitButton('Send Invitation'); ?>
                                        </div>
                                </div>

                            </div>
                        </div>
                	</div>

                </div>




            </div>

</form>
<?php /* echo CHtml::endForm(); */ ?>


<?php

// Invite friends

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

    $('[data-toggle="tooltip"]').tooltip();

    // $('[data-command="toggle-search"]').on('click', function(event) {
    $('body').on('click', '[data-command="toggle-search"]', function(event) {

        event.preventDefault();
        $(this).toggleClass('hide-search');

        if ($(this).hasClass('hide-search')) {
            $('.c-search').closest('.row').slideUp(100);
        }else{
            $('.c-search').closest('.row').slideDown(100);
        }

        $('#contact-list').searchable({
            searchField: '#contact-list-search',
            selector: 'li',
            childSelector: '.col-xs-12',
            show: function( elem ) {
                elem.slideDown(100);
            },
            hide: function( elem ) {
                elem.slideUp( 100 );
            }
        })


    })

    // Callback for DB invite request
    function fb_invite_callback(response) {
        $('input:checkbox').removeAttr('checked');
        // TODO: Removeclass invited for all entries and clear checkboxes
       console.log(response);
    }

    // Submit the modal form and close the modal
    $('body').on('submit', '#frmInviteMyFriends', function(event) {

        event.preventDefault();


        var selected_friends = $('input[type=checkbox]:checked').map(function(_, el) {
            return $(el).val();
        }).get().join(',');

        FB.ui({method: 'apprequests',
             to: selected_friends,
             title: 'Join me at Florida.com',
             message: 'Join me at Florida.com. Search. Discuss. Travel!',
           }, fb_invite_callback);


        return false; // avoid to execute the actual submit of the form.
    });


EOD;

Yii::app()->clientScript->registerScript('friend_list', $script, CClientScript::POS_READY);

?>