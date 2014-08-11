<?php

Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=false", CClientScript::POS_HEAD);


    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);

    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-rating-input/src/bootstrap-rating-input.js', CClientScript::POS_END);

    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery-searchable/dist/jquery.searchable-1.1.0.min.js', CClientScript::POS_END);

?>

<?php

$listCities         = $data['listCities'];
$myLocation         = $data['myLocation'];

?>

<style>

/* Remove gutter */
/* .row .col:not (:first-child ),.row .col:not (:last-child ) { */
/* 	padding-right: 0px; */
/* 	padding-left: 0px; */
/* } */
.col {
    padding-left:3px;
    padding-right:3px;
}

.panel-body
{
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


.invited {
    border:solid 3px red;
    background: #FAE4E4;
}

</style>

<style>

.modal.modal-wide .modal-dialog {
  width: 90%;
}

.modal.modal-medium .modal-dialog {
  width: 60%;
}




.modal-wide .modal-body {
  overflow-y: auto;
}

#tallModal .modal-body p { margin-bottom: 900px }

</style>

<style>

/* .modal-dialog { */
/*   width: 1200px; */
/* } */

/* .modal-content { */
/*   width: 1200px; */
/*     margin-left:  0px; */
/*     margin-top: -60px; */
/* } */

</style>


<?php

$baseUrl = $this->createAbsoluteUrl('/');

$activityListUrl            = $baseUrl.'/concierge/activitylist/';
$activityTypeListUrl        = $baseUrl.'/concierge/activitytypelist/';

$leftpanelRefreshInterval   = Yii::app()->params['LEFTPANEL_REFRESH_INTERVAL'];

$script = <<<EOD

    var last_timestamp = 0;

    $("[rel='tooltip']").tooltip();

    $(document.body).on({
    mouseenter: function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)

    },
    mouseleave: function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)

    }
}, '.thumbnail');


//     $(document.body).on("hover",'.thumbnail',

//         function(){
//          //   debugger;

//             $(this).find('.caption').slideDown(250); //.fadeIn(250)
//         },
//         function(){
//         //    debugger;

//             $(this).find('.caption').slideUp(250); //.fadeOut(205)
//         }
//     );



    function loadInitialSearchValues()
    {

        $("#city_list").select2("data", {id: "{$myLocation->city_id}", text: "{$myLocation->city_name}" });
        loadCityGallery();
        getLeftPanelFeeds();
        $('#dowhat').select2('focus');       // Set focus

    }

    // /////////////////////////////////////////////////////////////////////////
    // Setup Select widgets
    // /////////////////////////////////////////////////////////////////////////
    // City list
    $("#city_list").select2({
        placeholder: "I am in...",
        allowClear: true
    });

    // Activity list

    $("#dowhat").select2({
      tags: true,
      maximumSelectionSize: 1,
      tokenSeparators: [",", " "],
      createSearchChoice: function(term, data) {
        if ($(data).filter(function() {
          return this.text.localeCompare(term) === 0;
        }).length === 0) {
          return {
            id: term,
            text: term
          };
        }
      },
      multiple: true,
      ajax: {
        url: '{$activityListUrl}',
        dataType: "json",
        data: function(term, page) {
          return {
            query: term
          };
        },
        results: function(data, page) {
          return {
            results: data
          };
        }
      }
    });

    $("#withwhat").select2({
      tags: true,
      maximumSelectionSize: 1,
      tokenSeparators: [",", " "],
      createSearchChoice: function(term, data) {
        if ($(data).filter(function() {
          return this.text.localeCompare(term) === 0;
        }).length === 0) {
          return {
            id: term,
            text: term
          };
        }
      },
      multiple: true,
      ajax: {
        url: '{$activityTypeListUrl}',
        dataType: "json",
        data: function(term, page) {
          return {
            query: term
          };
        },
        results: function(data, page) {
          return {
            results: data
          };
        }
      }
    });

    loadInitialSearchValues();


    // /////////////////////////////////////////////////////////////////////////
    // Activity widget
    // /////////////////////////////////////////////////////////////////////////



    // /////////////////////////////////////////////////////////////////////////
    // On change event handlers
    // /////////////////////////////////////////////////////////////////////////
    $(document.body).on("change","#city_list",function(){
        // TODO: Add onchange function here
        // City id is this.value;
        loadCityGallery();
        $('#dowhat').select2('focus');       // Set focus

    });


    $("#withwhat").on("change", function() {
      $( "#dowhen" ).focus();
      doSearch()
    });

    $("#dowhat").on("change", function() {

        doSearch();

        var txtActivity      = $("#dowhat").val();

        if (txtActivity.length == 0)
        {
            $("#withwhat").select2("val", "");
            return;
        }


        // TODO: Find a way of calling this function from the widget
    	var url         = '$baseUrl/concierge/loadactivitytype/activity/' + txtActivity;

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
            $('#withwhat').select2('focus');       // Set focus

		});
		$('#withwhat').select2('focus');          // Set focus

    });

    // /////////////////////////////////////////////////////////////////////////
    // Fetch updated feeds and load the left panel
    // /////////////////////////////////////////////////////////////////////////

    function getLeftPanelFeeds()
    {
    	var url         = '$baseUrl/concierge/loadpanel/panel/left/last_timestamp/' + last_timestamp;

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

            $("time.timeago").timeago();

    	});
    }


    // /////////////////////////////////////////////////////////////////////////
    // Set up left panel for automatic regular refresh
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

    }, (1000 * {$leftpanelRefreshInterval}));



    // /////////////////////////////////////////////////////////////////////////
    // Set up left panel for automatic regular refresh
    // /////////////////////////////////////////////////////////////////////////


  function doSearch() {

    var where_data       = $('#city_list').select2('data');
    var dowhat_data      = $('#dowhat').select2('data');
    var withwhat_data    = $('#withwhat').select2('data');

    var where            = where_data.text;
        where            = where.trim();

    // dowhat and withwhat are multiple select items
    var dowhat           = (dowhat_data.length > 0)?dowhat_data[0].text:'';
    var withwhat         = (withwhat_data.length > 0)?withwhat_data[0].text:'';

    var dowhen      = $('#dowhentimestamp').val();

    var search_report = 'YOU SEARCHED';

    if ((dowhat == "") && (withwhat == ""))
    {
        $('#concierge_results').html("");
        return;
    }

    if (dowhat == "")
    {
    //    $('#concierge_toolbar_activity').html("");
    }
    else
    {
        search_report += ' TO ' + dowhat;
    }

    if (withwhat == "")
    {
    //    $('#concierge_toolbar_activitytype').html("");
    }
    else
    {
        search_report += ' ' + withwhat;
    }

    if (where != "")
    {
        search_report += ' IN '+ where;
    }

    if (dowhen != "")
    {
        var formattedDate = $('#dowhen').val();
        search_report += ' ON '+ formattedDate;
    }

    var url         = '$baseUrl/concierge/dosearch/';

    $("#search_criteria_dowhat").val(dowhat);

    $("#report_search").html(search_report);


    $.post(url,
    {
      where:where,
      dowhat:dowhat,
      withwhat:withwhat,
      dowhen:dowhen
    },
    function(data,status){
        $('#panel_search_details').show();
        $('#concierge_results').html(data);
        $('#city_gallery').html("");
        $('#left_panel_feed').html("");
        getLeftPanelFeeds();

    });

  }




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

    var where_data       = $('#city_list').select2('data');

    var where            = where_data.text;

    var url              = '$baseUrl/concierge/gallery/';

    where                = where.trim()

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

//     // User click on single result picture.
//     $('body').on('click', '[name="play"]', function(event) {
//     });


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
        var idActivity = $(this).attr('rel');

        // BUG FIX: Change vent is not firing when #dowhat is populated below,
        // ...so we manually update the activity types
        if (txtActivity.length > 0)
        {
            // TODO: Find a way of calling this function from the widget
        	var url         = '$baseUrl/concierge/loadactivitytype/activity/' + txtActivity;

    		// process the form. Note that there is no data send as posts arguements.
    		$.ajax({
    			type 		: 'POST',
    			url 		: url,
    		    data 		: null,
    			dataType 	: 'html'
    		})
        }

        $("#dowhat").select2("val", "");
        $("#dowhat").select2("data", {id: idActivity, text: txtActivity});
        $("#withwhat").select2("val", "");

        doSearch();

    });

    // Handler for (popular) activity type clicks
    // Response is to display related activity types
    $('body').on('click', '.concierge_activitytype_tag', function(event) {

        var txtActivityType = $(this).text();
        var idActivityType = $(this).attr('rel');

        $("#withwhat").select2("data", {id: idActivityType, text: txtActivityType});

        doSearch();


    });



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


    // Clear the modal each time
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });


    // When the modal is loaded
    $('#modalBusinessDetails').on('shown.bs.modal', function(e) {
        // Show map
        initialize_map();
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

    // /////////////////////////////////////////////////////////////////////////
    // Business Details modal show
    // /////////////////////////////////////////////////////////////////////////
    // Launch the business details modal when the details link is clicked
    $('body').on('click', '.details_button_link', function(e) {

        var remote = $(this).attr("data-href");

        $("#modalBusinessDetails").modal({

            keyboard: true,
            remote: remote

        });
    });

    // /////////////////////////////////////////////////////////////////////////
    // Save Current Search
    // /////////////////////////////////////////////////////////////////////////
    // save the current save for the user.
    $('body').on('click', '#save_search', function(e) {

        url = '$baseUrl/concierge/savesearch/';

        $.post(url, null,
        function(data,status){
            $('#panel_search_details').show();
            $('#concierge_results').html(data);
            $('#city_gallery').html("");
            $('#left_panel_feed').html("");
            getLeftPanelFeeds();

        });
    });

    // /////////////////////////////////////////////////////////////////////////
    // Load Current Search
    // /////////////////////////////////////////////////////////////////////////
    // save the current save for the user.
    $('body').on('click', '.saved_search_item', function(e) {

        url = '$baseUrl/concierge/getsavedsearchjson/';

		// process the form. Note that there is no data send as posts arguements.
		$.ajax({
			type 		: 'POST',
			url 		: url,
		    data 		: { saved_search_id:$(this).attr('rel') },
			dataType 	: 'json'
		})
		// using the done promise callback
		.done(function(data) {

            if (data.result == false)
            {
                alert(data.message);
            }
            var savedSearch = data.search.search_details;

            $('#dowhat').tagsinput('remove', $("#dowhat").val());
            $('#dowhat').tagsinput('add', savedSearch.dowhat);
            $('#withwhat').tagsinput('remove', $("#withwhat").val());
            $('#withwhat').tagsinput('add', savedSearch.withwhat);
            $("#city").val(savedSearch.where);

		});

    });



EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

<?php

// Invite friends

$script = <<<EOD


    $('body').on('click', '.myfriend', function(event) {
        var $$          = $(this)
        var user_id     = $(this).attr('rel');

        if( !$$.is('.invited')){
            $$.addClass('invited');
            $('#my_friend_'+user_id).prop('checked', true);
            alert ( $(this).find('.name').html() );
        } else {
            $$.removeClass('invited');
            $('#my_friend_'+user_id).prop('checked', false);

        }
    })


// when .modal-wide opened, set content-body height based on browser height;
        //200 is appx height of modal padding, modal title and button bar

$("#modalInviteMyFriends").on("show.bs.modal", function() {
  var height = $(window).height() - 200;
  $(this).find(".modal-body").css("max-height", height);

//     debugger;

//     $('#contact-list').searchable({
//         searchField: '#contact-list-search',
//         selector: 'li',
//         childSelector: '.col-xs-12',
//         show: function( elem ) {
//             elem.slideDown(100);
//         },
//         hide: function( elem ) {
//             elem.slideUp( 100 );
//         }
//     })

});

    $('#modalInviteMyFriends').on('loaded.bs.modal', function (e) {
        $('#meeting_date').val($('#dowhen').val());
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

    // /////////////////////////////////////////////////////////////////////////
    // Invite my friends invitation
    // /////////////////////////////////////////////////////////////////////////
    // Launch the modal when the invite friends link is clicked
    $('body').on('click', '.invite_friends-modal', function(e){

        // Check that the date has been chosen.
        var dowhen      = $('#dowhentimestamp').val();
        if (dowhen == '')
        {
            alert('Please select a date for your planned invitation');
            $('#dowhen').focus();
            return false;
        }

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

        var url = '$baseUrl/concierge/sendfriendinvitations/';

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


EOD;

Yii::app()->clientScript->registerScript('friend_list', $script, CClientScript::POS_READY);

?>


<div id="modalInviteMyFriends" class="modal modal-medium fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Invite your Friends</h4>
      </div>
      <div class="modal-body">
        <p><!--  Body goes here --></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalBusinessDetails" class="modal modal-wide fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Business Details</h4>
      </div>
      <div class="modal-body">
        <p><!--  Body goes here --></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="modalBusinessDetailssssssssssss" tabindex="-1" role="dialog" aria-labelledby="titleBusinessDetails" aria-hidden="true">
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
        <!-- 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> -->
        <!-- 			<ol class="breadcrumb"> -->
        <!-- 			  <li><a href="#">Home</a></li> -->
        <!-- 			  <li class="active">Category</li> -->
        <!-- 			</ol> -->
        <!-- 		</div> -->

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
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 gradient-bg pull-left col" id="main_panel">
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
                                        <option></option>
                                    <?php foreach ($listCities as $itemCity) { ?>
                                        <option value="<?php echo (int) $itemCity['city_id']; ?>"<?php echo (($myLocation->city_name==$itemCity['city_name'])?" selected='selected' selected":'');?>>
                                            <?php echo CHtml::encode($itemCity['city_name']); ?>
                                        </option>
                                    <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
                            <input class="form-control" name="dowhat" id="dowhat"  type="text" autocomplete="off" value="">
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
                            <input class="form-control" name="withwhat" id="withwhat"  type="text" autocomplete="off" value="">
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
                            <input type="text" value="" id="dowhen" data-date-format="yyyy-mm-dd">
                            <input type="hidden" value="" id="dowhentimestamp">
                        </div>

                    </div>
                </div>
            </div>
            <!-- / ADDS PANEL-->
<?php if (!Yii::app()->user->isGuest) { ?>

            <!-- PANEL: Search Criteria and 'Save Search Button' -->
            <div class="panel panel-primary margin-top-10" id='panel_search_details'>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text">
                            <input type='hidden' id='search_criteria_dowhat'>
                            <input type='hidden' id='search_criteria_withwhat'>
                            <input type='hidden' id='search_criteria_where'>
                            <input type='hidden' id='search_criteria_when'>
                            <!--  SAVED SEARCH CRITERIA GOES HERE -->
                            <div id='report_search'></div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text">
                            <a id="save_search" class="btn btn-warning btn-sm" href="#" title=""
                                style="margin-top: 20px;"><i class="icon-angle-left"></i>
                                Save Search</a>

                            <div class="dropdown btn-group">
                                <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
                                    Change your Search
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" id='saved_search_list'>
<?php                               foreach ($data['saved_searches'] as $saved_search) { ?>
                                        <li><a class='saved_search_item' href="#" rel='<?php echo (int) $saved_search['search_id']; ?>'>
                                            <?php echo CHtml::encode($saved_search['search_name']); ?>
                                        </a>
<?php                               } ?>
                                    </li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
<?php } ?>


            <div class="panel panel-primary margin-top-10">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
 <?php                       $this->widget('application.components.ConciergeToolbar'); ?>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
                    </div>

                </div>
            </div>

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

                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">

                            <div id='concierge_results'>
                                <!-- Business results go here -->
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
