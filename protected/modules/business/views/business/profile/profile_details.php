<?php

    Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=false", CClientScript::POS_HEAD);

    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-rating-input/src/bootstrap-rating-input.js', CClientScript::POS_END);

?>

<style>

body {
    background:#fff;
}

#map_canvas {
	width: 500px;
	height: 500px;
}

hr {
    border: 0;
    height: 2px;
    margin:18px 0;
    position:relative;
    background: -moz-linear-gradient(left, rgba(255,0,0,0) 0%, rgba(255,0,0,0) 15%, rgba(255,0,0,0.65) 50%, rgba(255,0,0,0) 85%, rgba(255,0,0,0) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(255,0,0,0)), color-stop(15%,rgba(255,0,0,0)), color-stop(50%,rgba(255,0,0,0.65)), color-stop(85%,rgba(255,0,0,0)), color-stop(100%,rgba(255,0,0,0))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(left, rgba(255,0,0,0) 0%,rgba(255,0,0,0) 15%,rgba(255,0,0,0.65) 50%,rgba(255,0,0,0) 85%,rgba(255,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(left, rgba(255,0,0,0) 0%,rgba(255,0,0,0) 15%,rgba(255,0,0,0.65) 50%,rgba(255,0,0,0) 85%,rgba(255,0,0,0) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(left, rgba(255,0,0,0) 0%,rgba(255,0,0,0) 15%,rgba(255,0,0,0.65) 50%,rgba(255,0,0,0) 85%,rgba(255,0,0,0) 100%); /* IE10+ */
    background: linear-gradient(left, rgba(255,0,0,0) 0%,rgba(255,0,0,0) 15%,rgba(255,0,0,0.65) 50%,rgba(255,0,0,0) 85%,rgba(255,0,0,0) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ff0000', endColorstr='#00ff0000',GradientType=1 ); /* IE6-9 */
}

hr:before {
    content: "";
    display: block;
    border-top: solid 1px rgba(255,100,100,0.100);
    width: 100%;
    height: 1px;
    position: absolute;
    top: 50%;
    z-index: 1;
}


.business_name {
  font-size: 20px;
  color:purple;
}


/* Business Owner */
.glyphicon-lg
{
    font-size:4em
}
.info-block
{
    border-right:5px solid #E6E6E6;margin-bottom:25px
}
.info-block .square-box
{
    width:105px;min-height:100px;margin-right:22px;text-align:center!important;background-color:#676767;padding:10px 0
}
.info-block.block-info
{
    border-color:#20819e
}
.info-block.block-info .square-box
{
    background-color:#20819e;color:#FFF
}

</style>



<style>
      ul {
          padding:0 0 0 0;
          margin:0 0 0 0;
      }
      ul li {
          list-style:none;
          margin-bottom:25px;
      }
      ul li img {
          cursor: pointer;
      }

</style>


            <div class="panel panel-warning">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div class="business_name"><?php echo CHtml::encode($model->attributes['business_name']); ?></div>
                    </h3>
                </div>

                <div class="panel-body">

                <div class="row">

                    <div class="col-md-6">
                            <!--  Photo -->
                            <div class="col-lg-12">
                                <div
                                    style="border: 1px solid #066A75; padding: 3px; width: 450px; height: 450px;"
                                    id="left">
                                    <a href="#">
<?php
                                        if (!empty($model->attributes['image']))
                                        {
                                            if(filter_var($model->attributes['image'], FILTER_VALIDATE_URL))
                                            {
                                                $imageURL = $model->attributes['image'];
                                            }
                                            else
                                            {
                                                if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$model->attributes['image']))
                                                {
                                                    $imageURL = Yii::app()->request->baseUrl .'/uploads/images/business/'.$model->attributes['image'];
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
                                    <?php echo CHtml::image($imageURL, 'Business Image', array("width"=>"450px" ,"height"=>"450px", 'id'=>'business_main_image_view')); ?>
                                    </a>
                                </div>
                            </div>
                            <!-- Photo -->

                            <!-- Image Gallery-->
                            <div class="col-lg-12">
                                <h3>Photos :</h3><br/>

                                    <ul class="row">
<?php                                   foreach ($photos as $photo) { ?>
                                        <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                            <?php
                                                $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];

                                                if(filter_var($photo->path, FILTER_VALIDATE_URL))
                                                {
                                                    $imageURL = $photo->path;
                                                }
                                                else
                                                {
                                                    if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$photo->path))
                                                    {
                                                        $imageURL   = Yii::app()->request->baseUrl .'/uploads/images/business/'.$photo->path;
                                                    }
                                                }
                                            ?>
                                            <img class="img-responsive" src="<?php echo $imageURL; ?>" style="width:120px;width:120px;">
                                        </li>
<?php                                   } ?>
                                    </ul>
                            </div>
                            <!-- Image gallery -->


                    </div>

                    <hr />
                    <div class="col-md-6">

                        <!-- Featured category listings -->
                        <div class="featured_categories">

                            <?php $this->renderPartial('profile/featured_categories', array('lstFeaturedCategory'=>$lstFeaturedCategory)); ?>

                        </div>
                        <!-- ./Featured category listings -->

                        <hr>

                        <!-- New business listings -->
                        <div class="new_business_list">

                            <?php $this->renderPartial('profile/new_business_listing', array('lstNewBusiness'=>$lstNewBusiness)); ?>

                        </div>
                        <!-- ./New business listings -->

                        <hr>




<?php                   if ($model->claim_status == 'Unclaimed') { ?>
                                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('/business/business/claim', array('business_id' => $model->business_id  )); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Claim this Business.
                                </a>
<?php                   } else if ($business_owner != null) { ?>
                            <!-- Business Owner -->
                            <div class="items col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
                               <div class="info-block block-info clearfix">
                                    <div class="square-box pull-left">
<?php
                                        if ($businessOwnerPhoto)
                                        {

                                                if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/user/'.$businessOwnerPhoto->path))
                                                {
                                                    $imageURL = Yii::app()->request->baseUrl .'/uploads/images/user/'.$businessOwnerPhoto->path;
                                                }
                                                else
                                                {
                                                    $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                                }
                                        }
                                        else
                                        {
                                            $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                        }
?>
                                    <?php echo CHtml::image($imageURL, 'Business Image', array("width"=>"100px" ,"height"=>"100px", 'id'=>'business_owner_image')); ?>

                                    </div>
                                    <h4>Meet the Business Owner!</h4>
                                    <h5>Name: <?php echo CHtml::encode($business_owner->user['first_name'] . ' ' . $business_owner->user['last_name']); ?></h5>
                                    <span>Phone: <?php echo CHtml::encode($business_owner->user['mobile_number']); ?></span><br />
                                    <span>Email: <?php echo CHtml::encode($business_owner->user['email']); ?></span>
                                    <br />
                                    <a class="btn btn-xs btn-warning" href="<?php echo Yii::app()->createUrl('/webuser/profile/show/', array('user_id' => $business_owner->user['user_id'] )); ?>">
                                        <i class="glyphicon glyphicon-user"></i>
                                        View <?php  echo CHtml::encode($business_owner->user['first_name']); ?>'s details now .
                                </a>
                                </div>
                            </div>
<?php                   } ?>


                        <hr>


                            <div class="map_box">

                                <?php $this->renderPartial('profile/business_map', array('model'=>$model)); ?>

                            </div>
                            <hr>
-

                    </div>

                </div>
                <hr />

                <div class="row">
                    <div class="col-md-8">

                            <!-- Business description -->
                            <div class="col-lg-12">
                            <h3>About :</h3><br/>

                                <span class="business_description"><?php echo CHtml::decode($model->attributes['business_description']); ?></span>

                            </div>
                            <!-- ./Business description -->

                            <!-- Tags -->
                            <div class="col-lg-12">
                              <h3>Tags and Categories :</h3><br/>
<?php
                                  $labelStyle = array('label-default', 'label-primary', 'label-success', 'label-info', 'label-warning', 'label-danger');

                                  // Business categories
                                  $category_count = 0;
                                  foreach ($model->businessCategories as $businessCategory)
                                  {
                                      $labelType = $labelStyle[($category_count % count($labelStyle))];

                                      $modelCategory = Category::model()->findByPk($businessCategory->category_id);
                                      if ($modelCategory != null)
                                      {
?>
                                            <span class="label <?php echo $labelType; ?>"><?php echo CHtml::encode($modelCategory->category_name); ?></span>
<?php
                                      }

                                  }

?>

<?php
                                  // Business keywords
                                  $lstkeywords = explode(",", $model->business_keywords);

                                  foreach ($lstkeywords as $keywordIndex => $itemKeyword)
                                  {
                                       $labelType = $labelStyle[($keywordIndex % count($labelStyle))];
?>

                                        <span class="label <?php echo $labelType; ?>"><?php echo CHtml::encode($itemKeyword); ?></span>
<?php
                                  }

?>

                            </div>

                            <!-- Contact Details -->
                            <div class="col-lg-12">
                                <h3>Contact Details</h3>
                                <p>Address:<br/>
                                   <?php echo CHtml::encode($model->attributes['business_address1']); ?></p>
                                <p><?php echo CHtml::encode($model->attributes['business_address2']); ?></p>
                                <br/>
                                <p><?php echo CHtml::encode($model->attributes['business_city_id']); ?></p>
                                <br/>
                                <p><?php echo CHtml::encode($model->attributes['business_zipcode']); ?></p>
                                <br/>
                                <p>Phone : <?php echo CHtml::encode($model->attributes['business_phone']); ?></p>
                                <p>Ext : <?php echo CHtml::encode($model->attributes['business_phone_ext']); ?></p>
                                <p>Email : <?php echo CHtml::encode($model->attributes['business_email']); ?></p>
                                <p>Website : <?php echo CHtml::encode($model->attributes['business_website']); ?></p>
                                <p>&nbsp;</p>
                                <p>Business Hours : Open : <?php echo CHtml::encode($model->attributes['opening_time']); ?></p>
                                <p>Business Hours : Close : <?php echo CHtml::encode($model->attributes['closing_time']); ?></p>

                            </div>

                            <!-- Tags -->
                            <div class="col-lg-12">
                              <h3>Announcements :</h3><br/>
                              <ul>
<?php
                                  // Business categories
                                  $countAnnouncements = 0;

                                  foreach ($model->businessAnnouncements as $itemAnnouncement)
                                  {
                                      if ($countAnnouncements > 1)
                                      {
                                          break;
                                      }
                                      echo '<li><div class="announceent">'.$itemAnnouncement['content'].'</div></li>';
                                      $countAnnouncements++;
                                  }
?>
                                </ul>
                            </div>



                    </div>

                    <div class="col-md-4">

                        <div class="col-lg-12">


                            <!-- Reviews -->
                            <hr>
                            <div class="white-box" id='business_review'>

                                    <?php $this->renderPartial("profile/business_reviews", array('model' => $model)); ?>

                            </div>
                            <!-- /.Reviews -->

                            <!-- Advertisements-->
                            <hr>
                            <div class="white-box" id='business_review'>

                                    <?php $this->renderPartial("profile/advertisements", array('lstBusinessAdvertisment' => $lstBusinessAdvertisment)); ?>

                            </div>
                            <!-- /.Advertisements -->

                            <!-- Latest coupon -->
                            <hr>
                            <div class="white-box" id='business_review'>

                                    <?php $this->renderPartial("profile/business_coupons", array('lstCoupon' => $lstCoupon)); ?>

                            </div>
                            <!-- /.Latest coupon -->


                            <!-- Tell a friend -->
                            <hr>
                            <div class="white-box">
                                <?php $this->renderPartial("profile/tell_a_friend", array('model' => $model)); ?>
                            </div>
                            <!-- ./Tell a friend -->

                            <hr>

            <?php if (!Yii::app()->user->isGuest) { ?>
                            <!-- Report Business Closed -->
                            <div class="white-box" id='report_closed_business'>
                                <a id='pop-report-closed-biz' class="btn btn-md btn-danger" href="<?php echo Yii::app()->createUrl('/business/business/reportClosed', array('business_id' => $model->business_id  )); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Report Business Closed.
                                </a>
                                <!-- Review form popup -->
                                <div class="row" id="report-closed-biz" style="display:none;">
                                    <div class="col-md-12">
                                        <form accept-charset="UTF-8" action="" method="post" id='report-closed-biz_form'>
                                            <input type='hidden' id="business_id" name="business_id" value="<?php echo (int) $model->business_id; ?>">
                                            <textarea class="form-control animated" cols="30" rows="3" id="reference" name="reference" placeholder="Enter your details here..." rows="5"></textarea>

                                            <div class="text-right">
                                                <button class="close-report-closed btn btn-error btn-lg" type="reset">Cancel</button>
                                                <button class="btn btn-success btn-lg" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.Review form popup -->
                            </div>
                            <!-- ./Report Business Closed -->
            <?php } ?>


                            <hr>
                            <!-- Business Events listing -->
                            <div class="white-box">
                                <?php $this->renderPartial('profile/business_events', array('model' => $model->events)); ?>
                            </div>
                            <!-- ./Business Events listing -->

                            <hr>
                            <!-- Business Discussions -->
                            <div class="white-box">
                                <?php $this->renderPartial('profile/business_discussions', array('lstBusinessDiscussions' => $lstBusinessDiscussions)); ?>
                            </div>
                            <!-- ./Business Discussions -->


                        </div>

                    </div>



                </div>

                </div>

            </div>
            <!--  End of Panel -->


<?php

$baseUrl = $this->createAbsoluteUrl('/');

$imageBaseUrl = Yii::app()->request->baseUrl;

$friendListUrl = $baseUrl.'/myfriend/myfriend/autocompletelist/';



$script = <<<EOD

    // img-responsive - Our makshift image gallery.
    /* Review form */
    $('body').on('click', '.img-responsive', function(event) {

        event.preventDefault();

        var clickedimage = $(this).attr('src');
        $("#business_main_image_view").attr('src',clickedimage);

    });

	// pop-report-closed-biz toggle button
    // Show/hide pop-review-form
    $('body').on('click', '#pop-report-closed-biz', function(event) {
        event.preventDefault();
        $("#report-closed-biz").toggle();
    });

    /* Report biz closed form */
    $('body').on('submit', '#report-closed-biz_form', function(event) {

        event.preventDefault();

        var form_values = $(this).serialize();
        var url = '/business/business/reportclosed/';

        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(),
               success: function(data)
               {
                    results = $.parseJSON(data);
                    if(results.result) {
                        alert(results.message);
                        $('#report_closed_business').html(results.message);
                        $('#report_closed_business').attr('class', 'alert alert-success');
                    } else {
                        alert(results.message);
                    }

               }
        });

        return false; // avoid to execute the actual submit of the form.
    });


    function initialize_map()
    {

        var latitude= $("#map_latitude").val();
        var longitude= $("#map_longitude").val();

    	var mapCanvas = document.getElementById('map_canvas');
        var myLatLng = new google.maps.LatLng(latitude,longitude);
        var mapOptions = {
            center: myLatLng,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE
            }
        }
        try {
            var map = new google.maps.Map(mapCanvas, mapOptions);
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title:"Business Location"
            });
        } catch (err) {
            // Error Handling
        }
    }


    // Review
    // Show/hide pop-review-form
    $('body').on('click', '.pop-review-form', function(event) {
        event.preventDefault();
        $("#review-box").toggle();
        $('#review_rating').rating();
    });

    /* Review form */
    $('body').on('submit', '#review_form', function(event) {

        event.preventDefault();

        var form_values = $(this).serialize();
        var url = '/webuser/profile/reviewbusiness/';

        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(),
               success: function(data)
               {
                    results = $.parseJSON(data);
                    if(results.result) {
                        $('#review-box').html(results.message);
                        $('#review-box').attr('class', 'alert alert-success');
                    } else {
                        alert(results.message);
                    }


               }
        });

        $('[rel="review_popover"]').popover('hide');
        return false; // avoid to execute the actual submit of the form.
    });



    // Tell a friend
    $(document.body).on("change","#tell_a_friend",function(){
        var form_values = $(this).serialize();
        var url = '/myfriend/myfriend/reviewbusiness/';

        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(),
               success: function(data)
               {
                   alert(data);
               }
        });

    });

//     NOTE: This code is retained for future use. Needs testing once integrated. Refer browse.
//     function format(friend) {
//         if (!friend.id) return friend.text; // optgroup
//         return "<img class='friend_icon' src='{$imageBaseUrl}/uploads/images/user/" + friend.image + "' />" + friend.text;
//     }

//     $("#tell_a_friend").select2({
//         formatResult: format,
//         formatSelection: format,
//         escapeMarkup: function(m) { return m; },
//         ajax: {
//             url: "{$friendListUrl}",
//             dataType: 'json',
//             data: function (term) {
//                 return {
//                     query: term, // search term
//                     page_limit: 10
//                 };
//             },
//             results: function (data) {
//                 return {results: data, text:'City'};

//             }
//         },
//     })

        // Show map
        initialize_map();

EOD;

Yii::app()->clientScript->registerScript('business_claim', $script, CClientScript::POS_READY);

?>

