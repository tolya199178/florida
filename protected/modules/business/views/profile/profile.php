<?php 
//print_r($model);
//exit;
?>
<style>
#main {
	background-color: white;
	/* top: 66px; */
	margin-top: -36px;
	position: relative;

	/*   text-align: left; */
	/*   bottom: 3px; */
	/* /*   left: 0px; */
	*/
	/* /*   width: 23.4043%; */
	*/
	/*   padding-top: 10px; */
	/*   padding-right: 10px; */
	/*   padding-bottom: 10px; */
	/*   padding-left: 10px; */
	/*   box-shadow: #b0b0b0; */
	/*   z-index: 20; */
}
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="main">

                <!--  start anel -->
                <div class="row">
                    <br />
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="panel panel-warning">

                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <?php echo CHtml::link($model->attributes['business_name'], $model->attributes['business_name'], array('title' => $model->attributes['business_name'])); ?>                                
                                </h3>
                            </div>

                            <div class="panel-body">
                                <span class="business_description"><?php echo $model->attributes['business_description']; ?></span>

                                <div class="row">
                                    <div class="col-lg-9">
                                        <div
                                            style="border: 1px solid #066A75; padding: 3px; width: 152px; height: 152px;"
                                            id="left">
                                            <a href="#"><img
                                                src="/uploads/images/business/thumbnails/business-2-c1.png"
                                                alt="Image" width="150"
                                                height="150"></a>
                                        </div>

                                    </div>
                                    <div class="col-lg-3">
                                        <!--  List of icons -->

                                        <span class="label label-default">Not
                                            claimed</span> <span
                                            class="label label-success">Popular</span>
                                        <span class="label label-info">Advertiser</span>
                                        <span class="label label-warning">Top
                                            Rated</span> <span
                                            class="label label-danger">New</span>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--  end panel -->



            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="span8">
        <h5 class="main-title">
            <b>How it works </b> Project Collaboration
        </h5>
        <div id="flash_msg"></div>
    </div>
</div>
<div class="row">
    <div class="span8">
        <!-- business-list -->
        <div id="yw0"></div>
        <ul id="business-list" class="detail-page view_businessdetail">
            <li class="active">
                <div class="item">
                    <div class="meta-header">
                        <div class="company-name viewbusinessdetail_s">
                            <div class="pull-right">
                                <a href="#" id="yt0"><small><b>Claim your
                                            business</b></small></a>| <a
                                    class="open_report_modal" href="#"><small><b>Report</small></a>
                            </div>
                            <h4>
                                <a href="#">Vicolo Ristorante</a>
                            </h4>
                        </div>
                    </div>
                    <p class="company-cat">
                        <small class="pull-right"> 5389 Miles from your location
                        </small> <span class="label" /> Italian
                    </p>
                    <div class="meta-content">
                        <div class="meta">
                            <div class="left">
                                <p>

                                    <span class="rating_view" id="rating_2"> <input
                                        id="rating_2_0" value="1" type="radio"
                                        name="rating_2" /> <input
                                        id="rating_2_1" value="2" type="radio"
                                        name="rating_2" /> <input
                                        id="rating_2_2" value="3" type="radio"
                                        name="rating_2" /> <input
                                        id="rating_2_3" value="4" type="radio"
                                        name="rating_2" /> <input
                                        id="rating_2_4" value="5" type="radio"
                                        name="rating_2" />
                                    </span>
                                </p>
                                <address>
                                    Vicolo Ristorante<br> 216 Old Tappan,Old
                                    Tappan,NJ,07675,2014978777,Amex,Discover,Mastercard,Visa,Family
                                    / Children,Romantic,Casual,Moderate,50 - 100
                                    People,Full Bar,Italian,Private Party
                                    Room,TV,41.013908,-73.981789,ALL,Dinner,Lunch,Parking
                                    on Site,60975,Suggested,Carry Out,Sit
                                    Down,Wheelchair Access<br> <br> <br> <a></a>
                                </address>

                                <a href="#myreviews"
                                    class="btn btn-warning btn-small">Get
                                    Coupons</a>
                            </div>
                            <div class="pull-right">
                                <div class="biz-photo">
                                    <a href="javascript:void(0)"><img
                                        class="lazy result_bns_img"
                                        data-original="http://vrdcimage.restaurant.com/microsites/473553logo.jpg"
                                        width="120px" height="75px"
                                        src="/img/loader.gif" /></a>
                                </div>

                            </div>
                            <div class="row" style="margin-bottom: 18px">
                                <div class="span3" style="padding-top: 18px;">
                                    <strong><small>Working Hours</small></strong>
                                    <ul class="unstyled">
                                        <li><small>Time Not defined</small></li>
                                    </ul>

                                </div>
                                <div class="span2" style="padding-top: 18px;"></div>
                                <div class="span2" style="padding-top: 18px;"></div>
                            </div>
                            <p></p>
                            <hr>
                            <div class="share-widget"
                                style="margin-bottom: 18px">
                                <p>
                                    <a href="javascript:void(0);"
                                        class="btn btn-warning btn-small "
                                        onclick="openReviewmodal('/users/businessprofile/reviewpopup/id/Mg%3D%3D')"><i
                                        class="icon-edit icon-white"></i> Write
                                        a Review</a> <a
                                        class="btn btn-warning btn-small"
                                        href="#" id="yt1"><i
                                        class="icon-pencil icon-white"></i>
                                        Write Survey</a> <span
                                        class="btn btn-small"> <span id="yw1"></span>
                                    </span> <span class="btn btn-small"> <span
                                        id="yw2"></span>
                                    </span>
                                    <!--                            <span  class="btn btn-small">
                                <a href="#"><i class="icon-signal"></i> Send to Phone</a>
                            </span>-->

                                </p>

                            </div>
                        </div>

                    </div>
                </div>
            </li>
        </ul>
        <hr>
        <h3 class="subtitle">Reviews</h3>

        <div>
            <div id="yw3" class="list-view">
                <div class="items">
                    <span class="empty">No results found.</span>
                </div>
                <div class="keys" style="display: none"
                    title="/mybusiness/pr7o.html"></div>
            </div>
        </div>

        <hr>
        <div id='couponscode'>
            <h3 class="subtitle">
                Coupons <a class="pull-right" href="/business/coupons.html?id=2">View
                    all</a>
            </h3>
            <div class="white-box">
                <div class="row">
                    <div class="span2">
                        <a href="/business/coupons.html?id=2"><img
                            src="/images/site/cache/7b/ff/7bffca599fa43a4cec4fc3b6557a9199.jpg"
                            alt="" /></a>
                    </div>
                    <div id="preview" class="span5">
                        <p>Coupon</p>

                        <div class="box">
                            <h4 class="coupon-title">
                                <del>Your Price $10.00</del>
                                <span style='color: red'> $4.00</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div style="z-index: -1" class="askqus_popup modal fade" id="reportbsns">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4>Would you like to report this business</h4>
            </div>
            <div class="modal-body" id="report_body"
                style="overflow-y: no-content"></div>
        </div>
        <div style="z-index: -1;" class="askqus_popup modal fade" id="review">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h3>Write a review</h3>
            </div>
            <div class="modal-body" id="review_body"
                style="overflow-y: no-content; text-align: center">Please
                Wait....</div>

        </div>
        <script>

    //function to show report business modal
    $('document').ready(function (){
        $('.open_report_modal').live('click',function(e){
            e.preventDefault();
            var url = 'http://sandbox.florida.com/users/businessprofile/report/id/Mg%3D%3D';
            $.get(url,function(data){
                $('#report_body').html(data);
                showPopup('reportbsns');
            });
        });
    });

    /* Open model Popup */
    function showPopup(id)
    {
        $('#'+id).css('z-index','9999');
        $('#'+id).modal('toggle');

    }
    /* Show Flash message */

    function showFlashMsg()
    {
        $("#flash_msg").show();
        $("#flash_msg").animate({
            opacity: 1.0
        }, 5000).fadeOut("slow");
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    }


    function saveReport()
    {
        var data=$("#report-form").serialize();
        $.ajax({
            type: 'POST',
            url: 'http://sandbox.florida.com/users/businessprofile/savereport',
            data:data,
            success:function(data){
                 var result = data.split('||');
                 if(result[0] == 1) {
                    $('#reportbsns').modal('toggle');
                    $("#flash_msg").html(result[1]);
                    showFlashMsg(result[0]);
                 }
                 else {
                     $('#'+result[0]).html(result[1]);
                     $('#'+result[0]).show();
                     return;
                 }
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
            },

            dataType:'html'
        });
    }

    //function to open write review modal
    function openReviewmodal(url){
        showPopup('review');
        $.ajax({
            type: 'GET',
            url: url,
            data:'',
            success:function(data){
               $('#review_body').html(data);
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
            },

            dataType:'html'
        });
    }



    //function to save review
    function saveReview()
    {

        var data=$("#reviews-form").serialize();
        $.ajax({
            type: 'POST',
            url: 'http://sandbox.florida.com/users/businessprofile/savereview/redirect/true',
            data:data,
            success:function(data){
                $('.errorMessage').hide();
                 var result = data.split('||');
                 var cur_index = $('#cur_index').val();
                 if(result[0] == 1) {
                    location.reload();
                 }
                 else {
                     showErrorMsg(result);
                 }
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
            },

            dataType:'html'
        });
    }

    //function to show error msg of modal
    function showErrorMsg(result){
        $('.errorMessage').hide();
        var arrLength = result.length;
        for(i=0;i<arrLength-2;i++){
           $('#'+result[i]).html(result[i+1]);
           $('#'+result[i]).show();
        }
        return;
    }

</script>
        <!-- End Business List -->
    </div>
    <div class="span4">
        <div class="box">

            <div id="yw6" class="gmap3" style="width: 281px; height: 200px"></div>
        </div>
        <hr>

        <div class="advert">
            <link href="/css/webwidget_slideshow_dot.css" rel="stylesheet"
                type="text/css" />
            <script src="/js/webwidget_slideshow_dot.js"></script>
            <script type="text/javascript">
    $(function() {
        $("#demo3").webwidget_slideshow_dot({
            slideshow_time_interval: '2000',
            slideshow_window_width: '300',
            slideshow_window_height: '250',
            directory: '/img/slider/'
        });
    });
</script>
            <div style="position: relative; top: 20px;">
                <div id="demo3" class="webwidget_slideshow_dot">
                    <ul>
                        <li><a> <script type="text/javascript"><!--
google_ad_client = "ca-pub-3922452437475290";
/* TS Template */
google_ad_slot = "5515148635";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script> <script type="text/javascript"
                                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></a></li>
                        <li><a href="http://www.google.com"><img
                                src="/images/site/cache/c0/74/c07458d0d16e957413bbc4a95ec24d09.jpg"
                                alt="" /></a></li>
                        <li><a href="http://www.gmail.com"><img
                                src="/images/site/cache/02/ed/02edd6666d2dc1106774c5817b9505bc.jpg"
                                alt="" /></a></li>
                        <li><a href="http://www.google.com"><img
                                src="/images/site/cache/6b/ff/6bff1cc1fe68512535add66f4318fc54.jpg"
                                alt="" /></a></li>
                        <li><a href="http://www.optisolbusiness.com"><img
                                src="/images/site/cache/c0/74/c07458d0d16e957413bbc4a95ec24d09.jpg"
                                alt="" /></a></li>
                        <li><a href="http://http://www.nokia.com/in-en/"><img
                                src="/images/site/cache/1d/93/1d93e81bcf8726634b50d248322a8dfc.jpg"
                                alt="" /></a></li>
                        <li><a href="http://www.optisolbusiness.com"><img
                                src="/images/site/cache/f7/cf/f7cfabfb26c9c64aeb4d3e178c67490b.jpg"
                                alt="" /></a></li>
                        <li><a href="http://www.florida.com"><img
                                src="/images/site/cache/45/2b/452b1f369c98b9f9a8a80fceb5ba40fa.jpg"
                                alt="" /></a></li>
                    </ul>

                </div>
            </div>
        </div>
        <hr>

        <div class="white-box featured">
            <h4>See what people are talking about your business</h4>
            <p>Add your business to florida.com and grow...</p>
            <hr>
            <a class="button special bada" href="/createbusiness.html">Add a new
                business</a>
        </div>

        <hr>
        <div class="white-box">
            <h5 class="sidebar-title special">New Business</h5>
            <ul class="sidebar-list">
                <li>
                    <div class="meta">
                        <p>
                            <a href="#"> <b>tes</b>
                            </a>
                        </p>
                        <p>
                            <small>Abbeville</small>
                        </p>
                        <p>
                            <small>Catering Services</small> <br>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="meta">
                        <p>
                            <a href="#"> <b>jygugctyfc</b>
                            </a>
                        </p>
                        <p>
                            <small>Abbeville</small>
                        </p>
                        <p>
                            <small>Videographer</small> <br>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="meta">
                        <p>
                            <a href="#"> <b>mdu-kp</b>
                            </a>
                        </p>
                        <p>
                            <small>Anna Maria</small>
                        </p>
                        <p>
                            <small>Event Planning</small> <br>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="meta">
                        <p>
                            <a href="#"> <b>My Another Test Business</b>
                            </a>
                        </p>
                        <p>
                            <small>Miami Beach</small>
                        </p>
                        <p>
                            <small>Honeymoon</small> <br>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="meta">
                        <p>
                            <a href="#"> <b>Test my business</b>
                            </a>
                        </p>
                        <p>
                            <small>Abbeville</small>
                        </p>
                        <p>
                            <small>Event Planning</small> <br>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <hr>
        <div class="widget white-box">
            <div class="category-name">
                <h5>Discussions</h5>
            </div>
            <ul id="myTab" class="nav nav-tabs three-tabs discussion">
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="likes">
                    <ul class="sidebar-list">
                        <li>
                            <div class="avatar">
                                <a href="/jkp.indhu"><img class="result_bns_img"
                                    width="32px" height="32px"
                                    src="/images/site/cache/24/5d/245d3d47d20521c60e96ab746e5a4131.JPG"
                                    alt="jkp.indhu" /></a>
                            </div>
                            <div class="meta">
                                <strong><p>
                                        <a
                                            href="/users/discussions/answer/id/rb7o">sdffdfd</a>
                                    </p> </strong>
                                <p>
                                    <small> <a href="/jkp.indhu">jkp.indhu</a>&nbsp
                                        0&nbsp comments -&nbsp <span
                                        class="time">Nov 15' 13 @ 01:35<br>
                                    </span>
                                    </small>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="avatar">
                                <a href="/jkp.indhu"><img class="result_bns_img"
                                    width="32px" height="32px"
                                    src="/images/site/cache/24/5d/245d3d47d20521c60e96ab746e5a4131.JPG"
                                    alt="jkp.indhu" /></a>
                            </div>
                            <div class="meta">
                                <strong><p>
                                        <a
                                            href="/users/discussions/answer/id/rL7o">sdffdfd</a>
                                    </p> </strong>
                                <p>
                                    <small> <a href="/jkp.indhu">jkp.indhu</a>&nbsp
                                        8&nbsp comments -&nbsp <span
                                        class="time">Nov 15' 13 @ 01:35<br>
                                    </span>
                                    </small>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="avatar">
                                <a href="/jkp.indhu"><img class="result_bns_img"
                                    width="32px" height="32px"
                                    src="/images/site/cache/24/5d/245d3d47d20521c60e96ab746e5a4131.JPG"
                                    alt="jkp.indhu" /></a>
                            </div>
                            <div class="meta">
                                <strong><p>
                                        <a
                                            href="/users/discussions/answer/id/q77o">hbsdjhbsjdg</a>
                                    </p> </strong>
                                <p>
                                    <small> <a href="/jkp.indhu">jkp.indhu</a>&nbsp
                                        0&nbsp comments -&nbsp <span
                                        class="time">Nov 15' 13 @ 01:27<br>
                                    </span>
                                    </small>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="avatar">
                                <a href="/Ftest"><img class="result_bns_img"
                                    width="32px" height="32px"
                                    src="/images/site/cache/01/c4/01c4996b693fea93581decd5b8c43714.png"
                                    alt="Ftest" /></a>
                            </div>
                            <div class="meta">
                                <strong><p>
                                        <a
                                            href="/users/discussions/answer/id/qr7o"><b><p>hbsdjhbsjdg</p></b></a>
                                    </p> </strong>
                                <p>
                                    <small> <a href="/Ftest">Ftest</a>&nbsp
                                        0&nbsp comments -&nbsp <span
                                        class="time">Oct 25' 13 @ 10:22<br>
                                    </span>
                                    </small>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="avatar">
                                <a href="/jkp.indhu"><img class="result_bns_img"
                                    width="32px" height="32px"
                                    src="/images/site/cache/24/5d/245d3d47d20521c60e96ab746e5a4131.JPG"
                                    alt="jkp.indhu" /></a>
                            </div>
                            <div class="meta">
                                <strong><p>
                                        <a
                                            href="/users/discussions/answer/id/qb7o">How
                                            are</a>
                                    </p> </strong>
                                <p>
                                    <small> <a href="/jkp.indhu">jkp.indhu</a>&nbsp
                                        1&nbsp comments -&nbsp <span
                                        class="time">Mar 14' 13 @ 00:46<br>
                                    </span>
                                    </small>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <div class="white-box">
            <h5 class="sidebar-title">
                <b>Coupons</b> <a class="pull-right"
                    href="/business/coupons.html?id=2">View all</a>
            </h5>
            <ul class="sidebar-list">

                <li>
                    <div class="meta">

                        <a href="/business/coupons.html?id=2"><img
                            src="/images/site/cache/70/8d/708d76f11293015611ccc25de77021ca.jpg"
                            alt="" /></a>
                    </div>
                </li>

            </ul>
        </div>
        <hr>
        <div class="white-box">

            <h5 class="sidebar-title">
                <b>Business Reviews</b>
            </h5>
            <ul class="sidebar-list">Review not yet...
            </ul>
        </div>
        <hr>
        <div class="white-box">
            <h5 class="sidebar-title">
                <b>Upcoming Events</b>
            </h5>
            <ul class="sidebar-list">Event not yet...
            </ul>

        </div>
    </div>
</div>