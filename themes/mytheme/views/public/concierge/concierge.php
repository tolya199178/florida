<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/js/vendor/typeahead/typeahead.bundle.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-rating-input/src/bootstrap-rating-input.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/timeago/jquery.timeago.js', CClientScript::POS_END);


Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js', CClientScript::POS_END);


?>
<style>
<!--
#sidebar
{
  background-color: white;
  text-align: left;
  position: fixed; /* TODO:  Maybe fix for fixed size. Do not delete until fixed */
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
  overflow-x:auto;
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
  overflow-x:auto;

}

.rightpanel {
  background-color: yellow;
   bottom: 3px;
}

.typeahead,
.tt-query,
.tt-hint {
  width: 250px;
/*   height: 30px; */
  padding: 8px 12px;
/*   font-size: 24px; */
/*   line-height: 30px; */
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
-
.typeahead {
  background-color: #fff;
}

.typeahead:focus {
  border: 2px solid #0097cf;
}

.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-dropdown-menu {
  width: 250px;
  margin-top: 12px;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
  padding: 3px 20px;
/*   font-size: 18px; */
  line-height: 24px;
}

.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;

}

.tt-suggestion p {
  margin: 0;
}

.cities {
   float:right;
}

.activities {
   float:right;
}

#city {
  min-width: 250px;
}


-->
</style>

<style>
<!--
.product, .product-img {
  width:260px;
  height:260px;
  position:relative;
  transition:.7s;
  -webkit-transition:.7s;
  z-index:2;
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
  width:260px;
  height:260px;
  position:relative;
  overflow: hidden;
  margin-top:-263px;
  transition:.7s;
  -webkit-transition:.7s;
  z-index:2;
}

.product {
  margin: 20px auto;
  -webkit-box-shadow: -2px 3px 2px rgba(0,0,0,0.5);
          box-shadow: -2px 3px 2px rgba(0,0,0,0.5);
  background:#000;
}

.sale, .info-block, .product-title, .product-description, .product-sale, .product-prize, .button-buy, .play, .more, .add {
  position:absolute;
  z-index:3;
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
  z-index:2;
}

.sale {
  font-size:11px;
  color:#fff;
  -webkit-transform:rotate(45deg);
  top:52px;
  left:2px;
}

.info-block {
  height:130px;
  width:260px;
  background:rgba(255,255,255,.85);
  bottom:0px;
  margin-bottom:-70px;
  transition:.7s;
}

.product-title {
  color:#222;
  font-size:1em:
  font-weight:400;
  top:12px;
  left:15px;
}

.product-description {
  width:228px;
  top:32px;
  left:16px;
  font-family: 'helvetica neue';
  font-size: 0.8em;
  font-weight: 400;
  color: #7d7d7d;
  border-bottom:1px solid #dadada;
  padding-bottom:15px;
}

.product-sale {
  color: #e74c3c;
  font-size: 1em;
  font-weight: 700;
  font-family: 'helvetica neue';
  right:15px;
  top:12px;
}

.product-prize {
  color:#7d7d7d;
  font-size:0.8em;
  font-weight:400;
  font-family:'helvetica neue';
  right:17px;
  top:32px;
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
  bottom:15px;
  left:15px;
  cursor:pointer;
  transition:.4s;
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
  height:44px;
  bottom:15px;
  right:35px;
  cursor:pointer;
  transition:.4s;
}

.add:hover {
  background:#27ae60;
}

.product:hover .info-block {
  margin-bottom:0;
}

.product:hover .product-img {
  margin-bottom:0;
  opacity:0.4;
}

.product:hover input[name="play"] + label span {
  opacity:1;
}

 .product:hover .more {
   opacity:1;
 }

.more {
  background-color: #4f4f4f;
  top: 50px;
  left: 15px;
  background-image: url(http://webstudios.dk/resources/img/share-img.png);
  width: 30px;
  height: 30px;
  cursor:pointer;
  opacity:0;
  transition:.7s;
  z-index:2;
}

.more:hover {
  background-color: #3f3f3f;
  background-image: url(http://webstudios.dk/resources/img/share-img.png);
}


/* .nav { */
/*   background: #4f4f4f; */
/*   height:250px; */
/*   margin-left:0; */
/*   top:5px; */
/*   width:250px; */
/*   z-index:-4; */
/*   font-weight:700; */
/*   color:#fff; */
/*   font-size:12px; */
/*   transition:.4s ease-out .1s; */
/* } */

/* .nav ul li { */
/*   padding:13px 10px; */
/*   width:50px; */
/*   background:#333; */
/*   border-bottom:1px solid #444; */
/*   cursor:pointer; */
/*   list-style: none; */
/* } */

/* .nav ul { */
/*   margin-left: -35px; */
/* } */

/* .nav ul li:hover { */
/*   background:#222; */
/* } */

/* .more:hover ~ .nav { */
/*   margin-left:-80px; */
/*   transition:.4s; */
/* } */

/* .nav:hover { */
/*   margin-left:-80px; */
/* } */

/* .nav:hover .info-block { */
/*   margin-bottom:0; */
/* } */



input[type="checkbox"] {
  display:none;
}

input[name="play"] + label span {
  opacity:0;
  position:absolute;
  background-color: #e74c3c;
  top: 15px;
  left: 15px;
  width: 30px;
  height: 30px;
  cursor:pointer;
  background-image: url(http://webstudios.dk/resources/img/play-img.png);
  transition:.7s;
  z-index:99;
}

input[name="play"]:checked + label span {
  background:#c0392b;
  z-index:9999;
}

/*
.video {
  text-align:center;
  font-size:11px;
  width:260px;
  height:260px;
  position:absolute;
  background:#fff;
  line-height:260px;
  top:0;
  z-index:-9;
}
*/

input[name="play"]:checked ~ .video {
  z-index:999;
}

div.bootstrap-tagsinput {
  width: 150px;
  outline: none;
  border: 0;
  height:35px;
}

#dowhen {
  width: 150px;
  outline: none;
  border: 0;
  height:35px;
}

/* div.bootstrap-tagsinput > input{ */
/*   width: 250px; */
/* } */


.result_button_link  {
  color: #fff;
}

.add:hover {
  color: #fff;
}
-->


</style>

<!--  City gallery -->
<style type="text/css">
h2{
    margin: 0;
    color: #666;
    padding-top: 90px;
    font-size: 52px;
    font-family: "trebuchet ms", sans-serif;
}
.item{
    background: #333;
    text-align: center;
    height: 450px !important;
}
.carousel{
    margin-top: 20px;
}
.bs-example{
	margin: 20px;
}


.invited {border:solid 3px red}

</style>


<?php

$local_list = City::model()->getListjson();

$script = <<<EOD

// Load the city list for type ahead
var numbers = new Bloodhound({
  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.city_name); },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   local: {$local_list}
});

// initialize the bloodhound suggestion engine
numbers.initialize();

// instantiate the typeahead UI
$('.cities .typeahead')
   .typeahead(null, {
       displayKey: 'city_name',
       source: numbers.ttAdapter()
       })
    .on('typeahead:selected', function(e, datum){
          loadCityGallery();
          $('#dowhat').tagsinput('focus');
     });


    // /////////////////////////////////////////////////////////////////////////
    // Fetch updated feeds and load the left panel
    // /////////////////////////////////////////////////////////////////////////
    var last_timestamp = 0;
    function getLeftPanelFeeds()
    {
    	var url         = '/concierge/loadpanel/panel/left/last_timestamp/' + last_timestamp;

    	$.ajax({
    		type 		: 'GET',
    		url 		: url,
    	    data 		: null,
    		dataType 	: 'html'
    	})
    	// using the done promise callback
    	.done(function(data) {

            var source = $('<div>' + data + '</div>');


            var feed_update_list = source.find('#feedresult').html();
            $('#left_panel_feed').prepend(feed_update_list);

            last_timestamp = source.find('#last_timestamp').html();

//             if (last_timestamp === undefined)
//             {
//                 last_timestamp = -1;
//             }
//             else
//             {
                $("time.timeago").timeago();
//             }


    	});
    }


    // /////////////////////////////////////////////////////////////////////////
    // On page load, load the left panel
    // /////////////////////////////////////////////////////////////////////////
    getLeftPanelFeeds();

    // /////////////////////////////////////////////////////////////////////////
    // On page load, load the left panel
    // /////////////////////////////////////////////////////////////////////////

    var auto_refresh = setInterval(
    function ()
    {
       getLeftPanelFeeds();
       if (last_timestamp === undefined)
       {
            clearInterval(auto_refresh);
            last_timestamp = -1;
       }

    }, (1000 * 60)); // refresh every 60 seconds






  function doSearch() {
    var where       = $("#city").val();
    var dowhat      = $("#dowhat").val();
    var withwhat    = $("#withwhat").val();
    var dowhen      = $('#dowhentimestamp').val();

    if ((dowhat == "") && (withwhat == ""))
    {
        $('#concierge_results').html("");
        return;
    }

    if (withwhat == "")
    {
    //    $('#concierge_toolbar_activitytype').html("");
    }

    if (dowhat == "")
    {
    //    $('#concierge_toolbar_activity').html("");
    }

    var url         = '/concierge/dosearch/';

    $.post(url,
    {
      where:where,
      dowhat:dowhat,
      withwhat:withwhat,
      dowhen:dowhen
    },
    function(data,status){
      $('#concierge_results').html(data);
        $('#city_gallery').html(data);
        // $('input.rating').rating();

    });

  }

    $('#dowhat').tagsinput({
    maxTags: 1
    });

    $('#withwhat').tagsinput({
    maxTags: 1
    });

    $("#dowhat").on("change", function() {
      doSearch();

        var txtActivity      = $("#dowhat").val();

        if (txtActivity.length == 0)
        {
            $('#withwhat').tagsinput('remove', $("#withwhat").val());
            return;
        }


        // TODO: Find a way of calling this function from the widget
    	var url         = '/concierge/loadactivitytype/activity/' + txtActivity;

		// process the form. Note that there is no data send as posts arguements.
		$.ajax({
			type 		: 'POST',
			url 		: url,
		    data 		: null,
			dataType 	: 'html'
		})
		// using the done promise callback
		.done(function(data) {

            // Populate the list of linked activity types
            $('#concierge_toolbar_activitytype').html(data);

            $('#withwhat').tagsinput('focus');

		});
    });

    $("#withwhat").on("change", function() {
      $( "#dowhen" ).focus();
      doSearch()
    });

    $('body').on('click', 'a.result_button_link', function(event) {

        var url         = $(this).attr("href");

		// process the form. Note that there is no data send as posts arguements.
		$.ajax({
			type 		: 'POST',
			url 		: url,
		    data 		: null,
			dataType 	: 'json'
		})
		// using the done promise callback
		.done(function(data) {


            var results = JSON.parse(data);

            if (results.result == false)
            {
                alert(results.message);
            }

		});

       event.preventDefault();
       return false;


    });

  function loadCityGallery() {
    var where       = $("#city").val();

    var dowhat      = $("#dowhat").val();
    var withwhat    = $("#withwhat").val();

    var url         = '/concierge/gallery/';

    $.post(url,
    {
      city:where,
    },
    function(data,status){
        $('#city_gallery').html(data);
     $("#myCarousel").carousel({
         interval : 5000,
         pause: false
     });
    });

  }

  // Load the default city on page load
  loadCityGallery();
  $('#dowhat').tagsinput('focus');


    $('body').on('change', '.rating', function() {

        var url = '/webuser/profile/reviewbusiness/';

		// process the form. Note that there is no data send as posts arguements.
		$.ajax({
			type 		: 'POST',
			url 		: url,
		    data 		: {
                             business_id:$(this).attr('rel'),
                             rating:$(this).val()
                          },
			dataType 	: 'json'
		})
		// using the done promise callback
		.done(function(data) {

            var results = JSON.parse(data);

            if (results.result == false)
            {
                alert(results.message);
            }

		});

    });



    // Business Review popover settings
    var popOverSettings = {
        placement: 'bottom',
        container: 'body',
        html: true,
        selector: '[rel="review_popover"]',
        callback: function() {
            $('input.rating').rating();
        },
        content: function () {
            var refid = $(this).attr('refid');
            $('#review_business_id').val(refid);
            return $('#review-box').html();
        }
    }

    $('body').popover(popOverSettings);
    // Hide
    $('body').on('click', '.close-review', function() {
          $('[rel="review_popover"]').popover('hide');
    });

    var tmp = $.fn.popover.Constructor.prototype.show;
    $.fn.popover.Constructor.prototype.show = function () {
        tmp.call(this);
        if (this.options.callback) {
            this.options.callback();
        }
    };

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
                    ;
               }
        });

        $('[rel="review_popover"]').popover('hide');
        return false; // avoid to execute the actual submit of the form.
    });

    // User click on single result picture.
    $('body').on('click', '[name="play"]', function(event) {
    });


     $("#myCarousel").carousel({
         interval : 5000,
         pause: false
     });



    // /////////////////////////////////////////////////////////////////////////
    // Concierge toolbar actions
    // /////////////////////////////////////////////////////////////////////////
    // Handler for (popular) activity click
    // Response is to display related activity types
    $('body').on('click', '.concierge_activity_tag', function(event) {
        var txtActivity = $(this).text();

        $('#dowhat').tagsinput('remove', $("#dowhat").val());
        $('#dowhat').tagsinput('add', txtActivity);
        $('#withwhat').tagsinput('remove', $("#withwhat").val());


    });

    // Handler for (popular) activity type clicks
    // Response is to display related activity types
    $('body').on('click', '.concierge_activitytype_tag', function(event) {
        var txtActivityType = $(this).text();


// BUG : The two statements are triggering two doSearch() calls
// BUG : Perhaps the answer lies here :
// BUG : http://stackoverflow.com/questions/21336457/bootstrap-tags-input-how-to-bind-function-to-event-itemadded-and-itemremoved/21336824#21336824
// alert('Bug alert: 2 doSearch() calls triggered. FIXME.');
        $('#withwhat').tagsinput('remove', $("#withwhat").val());
        $('#withwhat').tagsinput('add', txtActivityType);


    });

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

    // ////////////////////////////////////////////////////
    // Wizard
    // ///////////////////////////////////////////////////////

    $('body').on('click', '.wiz-next-nav', function(event) {

        $(".step-1").hide();
        $(".step-2").show();

        $(".wiz-prev-nav").show();
        $(".wiz-finish-nav").show();
        $(".wiz-next-nav").hide();

        return false;
    });

    $('body').on('click', '.wiz-prev-nav', function(event) {

        $(".step-2").hide();
        $(".step-1").show();

        $(".wiz-prev-nav").hide();
        $(".wiz-next-nav").show();
        $(".wiz-finish-nav").hide();


        return false;
    });

    // /////////////////////////////////////////////////////////////////////////
    // Time picker
    // /////////////////////////////////////////////////////////////////////////
    $('body').on('click', '.form_datetime', function(event) {
         $(".form_datetime")
         .datetimepicker({
        format: "dd MM yyyy - HH:ii p",
        todayBtn: true,
        todayHighlight:true,
     autoclose: true
        })
        .on('changeDate', function(ev){
            // $(this).hide();
        })
    });


    // /////////////////////////////////////////////////////////////////////////
    // Invite my friends invitation
    // /////////////////////////////////////////////////////////////////////////
    // Launch the modal when the invite friends link is clicked
    $('body').on('click', '.launch-modal', function(e) {

        var remote = $(this).attr("data-href");

        $("#modalInviteMyFriends").modal({

            keyboard: false,
            remote: remote

        });
    });

    // Submit the modal form and close the modal
    $('body').on('submit', '#frmInviteMyFriends', function(event) {

        event.preventDefault();

        var form_values = $(this).serialize();

        var url = '/concierge/sendfriendinvitations/';

        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(),
               success: function(data)
               {
                    $('#modalInviteMyFriends').modal('hide');
               }
        });

        return false; // avoid to execute the actual submit of the form.
    });

    // Clear the modal each time
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    $('#dowhen').datetimepicker({
            format: "dd MM yyyy",
            autoclose: true,
            todayBtn: true,
            minView: "month",
            initialDate: null
    })
    .on('changeDate', function(ev){
        var datetime = ev.date.valueOf();
        $('#dowhentimestamp').val(datetime)
        doSearch();
    });

EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>


<!-- Modal -->
<div class="modal fade" id="modalInviteMyFriends" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="container-full">

    <div class="row">
        <div class="col-lg-2">
            <div id="sidebar"  >
                <div class="alert alert-warning">
                <p>Follow your friends here now ! </p>
                    <p class="center"><a href="#" class="btn btn-info">Follow your friends here.</a></p>
                </div>
                <div id='left_panel_feed'>

                </div>
            </div>
        </div>

        <div class="col-lg-10 col-lg-offset-0">
                <div id="mainpanel">
                    <!-- Search section -->
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="city" class="heading">I AM IN &nbsp;&nbsp;&nbsp;</label>
                            <div class="cities">
                                <input class="typeahead form-control" name="city" id="city"  type="text" autocomplete="off" value="<?php echo $data['city']; ?>" placeholder="I am in...">
                            </div>
                        </div>

                        <div class="col-lg-2">
                                <label for="dowhat" class="heading">I WANT TO &nbsp;&nbsp;&nbsp;</label>
                        </div>

                        <div class="col-lg-6" style="border: 1px solid silver;">
                            <div class="col-lg-3 col-lg-offset-0">
                                <input class="form-control" name="dowhat" id="dowhat"  type="text" autocomplete="off" value="">
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control" name="withwhat" id="withwhat"  type="text" autocomplete="off" value="">
                            </div>
                            <div class="col-lg-3">
                                <input type="text" value="" id="dowhen" data-date-format="yyyy-mm-dd">
                                <input type="hidden" value="" id="dowhentimestamp">
                            </div>


                        </div>



                    </div>
                    <!-- /.Search section -->

                    <!-- Search results section -->
                    <div class="row">

                        <div class="col-lg-12">
<?php                       $this->widget('application.components.ConciergeToolbar'); ?>
                        </div>

                        <div class="col-lg-12" id='city_gallery'>
                            <!--  City Gallery goes here -->
                        </div>


                        <div class="col-lg-12">
                            <div id='concierge_results'>
                            </div>


                        </div>
                    </div>
                    <!-- /.Search results section -->



                </div>


        </div>
    </div>
</div>

<!-- Review form popup -->
            <div class="row" id="review-box" style="display:none;">
                <div class="col-md-12">
                    <form accept-charset="UTF-8" action="" method="post" id='review_form'>
                        <input type='hidden' id="review_business_id" name="review_business_id">
                        <textarea class="form-control animated" cols="50" id="review_text" name="review_text" placeholder="Enter your review here..." rows="5"></textarea>

                        <span><input type="number" name="review_rating" id="review_rating"  class="rating" value='' /></span>

                        <div class="text-right">
                            <button class="close-review btn btn-error btn-lg" type="reset">Cancel</button>
                            <button class="btn btn-success btn-lg" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
<!-- /.Review form popup -->
