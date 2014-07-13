
<?php

Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=false", CClientScript::POS_HEAD);


    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);

    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-rating-input/src/bootstrap-rating-input.js', CClientScript::POS_END);

?>

<?php

// Hack
$data['city'] = 'Miami';

?>

<style>

/* Remove gutter */
/* .row .col:not (:first-child ),.row .col:not (:last-child ) { */
/* 	padding-right: 0px; */
/* 	padding-left: 0px; */
/* } */
.col {
	padding-left: 3px;
	padding-right: 3px;
}

.panel-body {
	padding-top: 10px;
	padding-bottom: 10px;
}

.panel {
	margin-bottom: 2px;
	margin-top: 2px;
}

/* Full height left hand panel */
</style>


<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/js/vendor/typeahead/typeahead.bundle.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-rating-input/src/bootstrap-rating-input.js', CClientScript::POS_END);


?>
<style>
<!--
#sidebar {
	background-color: white;
	text-align: left;
	position: fixed;
	/* TODO:  Maybe fix for fixed size. Do not delete until fixed */
	top: 66px;
	bottom: 3px;
	/*   left: 0px; */
	/*   width: 23.4043%; */
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	box-shadow: #b0b0b0;
	z-index: 20;
	overflow-x: auto;
}

#mainpanel {
	background-color: white;
	text-align: left;
	position: fixed;
	top: 66px;
	bottom: 3px;
	/*   left: 0px; */
	width: 74%;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	box-shadow: #b0b0b0;
	z-index: 21;
	overflow-x: auto;
}

.rightpanel {
	background-color: yellow;
	bottom: 3px;
}


.cities {
	float: right;
}

.activities {
	float: right;
}

#city {
	min-width: 250px;
}
-->
</style>

<style>
<!--
.product,.product-img {
	width: 260px;
	height: 260px;
	position: relative;
	transition: .7s;
	-webkit-transition: .7s;
	z-index: 2;
}

.product-img-container {
	display: inline-block;
}

.product-img-container img {
	display: block;
	transition: all 0.5s linear;
	-webkit-transition: all 0.5s linear;
	-moz-transition: all 0.5s linear;
	-ms-transition: all 0.5s linear;
	-o-transition: all 0.5s linear;
}

.product-actions {
	width: 260px;
	height: 260px;
	position: relative;
	overflow: hidden;
	margin-top: -263px;
	transition: .7s;
	-webkit-transition: .7s;
	z-index: 2;
}

.product {
	margin: 20px auto;
	-webkit-box-shadow: -2px 3px 2px rgba(0, 0, 0, 0.5);
	box-shadow: -2px 3px 2px rgba(0, 0, 0, 0.5);
	background: #000;
}

.sale,.info-block,.product-title,.product-description,.product-sale,.product-prize,.button-buy,.play,.more,.add
	{
	position: absolute;
	z-index: 3;
}

.sale-tile {
	width: 50px;
	height: 100px;
	background: #e74c3c;
	position: absolute;
	top: -45px;
	right: -10px;
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
	-o-transform: rotate(-45deg);
	transform: rotate(-45deg);
	z-index: 2;
}

.sale {
	font-size: 11px;
	color: #fff;
	-webkit-transform: rotate(45deg);
	top: 52px;
	left: 2px;
}

.info-block {
	height: 130px;
	width: 260px;
	background: rgba(255, 255, 255, .85);
	bottom: 0px;
	margin-bottom: -70px;
	transition: .7s;
}

.product-title {
	color: #222;
	font-size: 1em:
  font-weight:400;
	top: 12px;
	left: 15px;
}

.product-description {
	width: 228px;
	top: 32px;
	left: 16px;
	font-family: 'helvetica neue';
	font-size: 0.8em;
	font-weight: 400;
	color: #7d7d7d;
	border-bottom: 1px solid #dadada;
	padding-bottom: 15px;
}

.product-sale {
	color: #e74c3c;
	font-size: 1em;
	font-weight: 700;
	font-family: 'helvetica neue';
	right: 15px;
	top: 12px;
}

.product-prize {
	color: #7d7d7d;
	font-size: 0.8em;
	font-weight: 400;
	font-family: 'helvetica neue';
	right: 17px;
	top: 32px;
}

.button-buy {
	/*   background: #e74c3c; */
	text-align: center;
	/*   line-height: 46px; */
	font-weight: 700;
	color: #fff;
	border: 0px solid #c0392b;
	border-bottom-width: 2px;
	/*   width:70px; */
	/*   height:44px; */
	bottom: 15px;
	left: 15px;
	cursor: pointer;
	transition: .4s;
}

.button-buy:hover {
	/*   background:#c0392b; */

}

.add {
	background: #2ecc71;
	text-align: center;
	line-height: 46px;
	font-weight: 700;
	color: #fff;
	border: 0px solid #27ae60;
	border-bottom-width: 2px;
	/*   width:50px; */
	height: 44px;
	bottom: 15px;
	right: 35px;
	cursor: pointer;
	transition: .4s;
}

.add:hover {
	background: #27ae60;
}

.product:hover .info-block {
	margin-bottom: 0;
}

.product:hover .product-img {
	margin-bottom: 0;
	opacity: 0.4;
}

.product:hover input[name="play"]+label span {
	opacity: 1;
}

.product:hover .more {
	opacity: 1;
}

.more {
	background-color: #4f4f4f;
	top: 50px;
	left: 15px;
	background-image: url(http://webstudios.dk/resources/img/share-img.png);
	width: 30px;
	height: 30px;
	cursor: pointer;
	opacity: 0;
	transition: .7s;
	z-index: 2;
}

.more:hover {
	background-color: #3f3f3f;
	background-image: url(http://webstudios.dk/resources/img/share-img.png);
}

input[type="checkbox"] {
	display: none;
}

input[name="play"]+label span {
	opacity: 0;
	position: absolute;
	background-color: #e74c3c;
	top: 15px;
	left: 15px;
	width: 30px;
	height: 30px;
	cursor: pointer;
	background-image: url(http://webstudios.dk/resources/img/play-img.png);
	transition: .7s;
	z-index: 99;
}

input[name="play"]:checked+label span {
	background: #c0392b;
	z-index: 9999;
}

input[name="play"]:checked ~ .video {
	z-index: 999;
}

div.bootstrap-tagsinput {
	width: 150px;
	outline: none;
	border: 0;
	height: 35px;
}

#dowhen {
	width: 150px;
	outline: none;
	border: 0;
	height: 35px;
}

.result_button_link {
	color: #fff;
}

.add:hover {
	color: #fff;
}

/* Hide on page load */
#panel_search_details {
	display: none;
}
-->
</style>

<!--  City gallery -->
<style type="text/css">
h2 {
	margin: 0;
	color: #666;
	padding-top: 90px;
	font-size: 52px;
	font-family: "trebuchet ms", sans-serif;
}

.item {
	background: #333;
	text-align: center;
	height: 450px !important;
}

.carousel {
	margin-top: 20px;
}

.bs-example {
	margin: 20px;
}

.invited {
	border: solid 3px red
}
</style>

<style>

.modal-dialog {
  width: 1200px;
}

.modal-content {
  width: 1200px;
    margin-left:  0px;
    margin-top: -60px;
}
</style>

<style>

/* Triangle breadcrumbs */
<!--
.category_breadcrumbs {
	text-align: left;
}
-->
</style>

<?php

$baseUrl = $this->createAbsoluteUrl('/');

$imageBaseUrl = Yii::app()->request->baseUrl;

$showlistingUrl = $baseUrl.'/business/business/showlisting/'.'category/'.$currentCategory;

$friendListUrl = $baseUrl.'/myfriend/myfriend/autocompletelist/';



$script = <<<EOD

// /////////////////////////////////////////////////////////////////////////////
// Business Listing
// /////////////////////////////////////////////////////////////////////////////
    var page = 0;

    function loadnewdata()
    {
        // do ajax stuff, update data.
         var url         = '$showlistingUrl'+'/page/'+page;

         $.ajax({ url: url,
                  cache: false,
                  success: function(data){
     	                var existing_content = $('#business_listing_container').html();

                        $('#business_listing_container').replaceWith('<div id="business_listing_container">'+existing_content+data+'</div>');

                        page++;
                  },
                  dataType: "html"
                });
    }

    setInterval(
      function (){
        if(($(document).height() - $(window).height() - $(document).scrollTop()) < 500){
    	   loadnewdata();
        }
      },
      500
    );

    // Run the initial listing load.
 	loadnewdata();

    $("#city_list").select2({
        placeholder: "I am in...",
        allowClear: true
    });



    $(document.body).on("change","#city_list",function(){
     alert(this.value);
    });


    // Clear the modal each time
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
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






    $('#modalBusinessDetails').on('shown.bs.modal', function(e) {

        // Show map
        initialize_map();


        function format(friend) {
            if (!friend.id) return friend.text; // optgroup
            return "<img class='friend_icon' src='{$imageBaseUrl}/uploads/images/user/" + friend.image + "' />" + friend.text;
        }
        $("#tell_a_friend").select2({
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function(m) { return m; },
            ajax: {
                url: "{$friendListUrl}",
                dataType: 'json',
                data: function (term) {
                    return {
                        query: term, // search term
                        page_limit: 10
                    };
                },
                results: function (data) {
                    return {results: data, text:'City'};

                }
            },
        })


    })

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
                   alert(data);
               }
        });

//         $('[rel="review_popover"]').popover('hide');
        return false; // avoid to execute the actual submit of the form.
    });

    // img-responsive - Our makshift image gallery in a modal.
    /* Review form */
    $('body').on('click', '.img-responsive', function(event) {

        event.preventDefault();

        var clickedimage = $(this).attr('src');
        $("#business_main_image_view").attr('src',clickedimage);

    });



	// pop-report-closed-biz toggle button
    // Show/hide pop-review-form
    $('body').on('click', '.pop-report-closed-biz', function(event) {
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
                   alert(data);
               }
        });

        $('[rel="review_popover"]').popover('hide');
        return false; // avoid to execute the actual submit of the form.
    });


EOD;

Yii::app()->clientScript->registerScript('biz_listing', $script, CClientScript::POS_READY);

?>


<div class="modal fade" id="modalBusinessDetails" tabindex="-1" role="dialog" aria-labelledby="titleBusinessDetails" aria-hidden="true">
    <div class="modal-dialog biz-details-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="titleBusinessDetails">Business Details</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Main concierge page .container -->
<div class="row  fill">

    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col" id="left_panel">


        <div class="panel panel-default margin-top-10">
            <div class="panel-heading">


                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4>
                            <p>Follow your friends here now !</p>
                            <p class="center">
                                <a href="#" class="btn btn-info">Follow your
                                    friends here.</a>
                            </p>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id='left_panel_feed'>
                                    <!-- Left panel feed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <!-- /Main blocks left side -->

    <!-- Teasers right side wrapper col-->
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 gradient-bg pull-left col"
        id="main_panel">
        <!-- ADDS PANEL-->
        <div class="panel panel-primary margin-top-10">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-">
                        <label for="city" class="heading">I AM IN
                            &nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="cities">

                            <select id="city_list" style="width:300px;" class="populate placeholder">
                            <?php foreach ($listCities as $itemCity) { ?>
                                <option value="<?php echo $itemCity->city_id; ?>"><?php echo Chtml::encode($itemCity->city_name); ?></option>
                            <?php } ?>
                            </select>

                        </div>

                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-">
                        <label for="city" class="heading">I AM LOOKING FOR
                            &nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-center">
                        <input class="form-control" name="dowhat" id="dowhat"
                            type="text" autocomplete="off" value="">
                    </div>
                </div>
            </div>
        </div>
        <!-- / ADDS PANEL-->

        <div class="row margin-top-3">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id='city_gallery'>
                            <!--  City Gallery goes here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULTS -->
        <div class="panel panel-primary margin-top-10">
            <div class="panel-body">
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-default margin-top-10">
                            <div class="panel-heading">
                                <h3>Search Other Categories</h3>
                            </div>

                            <div class="row margin-top-10">

                                <ul>
                                    <?php

                                        foreach ($listSubcategories as $objBusiness)
                                        {
                                            echo '<li>'.
                                                 CHtml::link(CHtml::encode($objBusiness['category_name']),
                                                             Yii::app()->createUrl('//business/business/browse', array('category' => $objBusiness['category_id'])),
                                                             array('class'=>"question-link", 'title'=>"")).
                                                 '</li>';
                                        }

                                    ?>
                				    </ul>



                            </div>
                        </div>
                    </div>

                    <div
                        class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">

                        <div id='category_breadcrumbs'>
                            <!-- Business results go here -->
<?php
                                $elementCount = 0;
                                foreach ($category_path as $path_component) {

                                    echo CHtml::link(CHtml::encode($path_component['name']),
                                                     Yii::app()->createUrl('//business/business/browse', array('category' => $path_component['id'])),
                                                     array('class'=>"question-link", 'title'=>""));
                                    $elementCount++;
                                    if ($elementCount < count($category_path))
                                    {
                                        echo ' &raquo ';
                                    }

                                }
?>
                            </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-default margin-top-10">
                            <div class="panel-heading">
                                <h3>Featured Business</h3>
                            </div>

                            <div class="row margin-top-10">

                                <div id="business_listing_container">
                                    <!--  Business listing goes here -->
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <!-- ./RESULTS -->





            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <a class="btn btn-warning btn-sm" href="#" title=""
                    style="margin-top: 20px;"><i class="icon-angle-left"></i>
                    Back to search results</a>
            </div>


        </div>
    </div>
    <!-- /Main blog .container -->
    <!-- Marketing messaging and featurettes
                ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
    <hr>

    <!-- /.container-->
</div>
