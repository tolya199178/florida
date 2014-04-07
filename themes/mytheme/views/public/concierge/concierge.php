<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/js/vendor/typeahead/typeahead.bundle.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.css');

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
  line-height: 46px;
  font-weight: 700;
  color: #fff;
  border: 0px solid #c0392b;
  border-bottom-width: 2px;
/*   width:70px; */
  height:44px;
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
          doSearch()
     });


  function doSearch() {
    var where       = $("#city").val();
    var dowhat      = $("#dowhat").val();
    var withwhat    = $("#withwhat").val();

    var url         = '/concierge/dosearch/';

    $.post(url,
    {
      where:where,
      dowhat:dowhat,
      withwhat:withwhat
    },
    function(data,status){
      $('#concierge_results').html(data);

    });

  }

    $('#dowhat').tagsinput({
    maxTags: 1
    });

    $('#withwhat').tagsinput({
    maxTags: 1
    });

    $("#dowhat").on("change", function() {
      doSearch()
    });

    $("#withwhat").on("change", function() {
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

EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

<div class="container-full">

    <div class="row">
        <div class="col-lg-2">
            <div id="sidebar"  >
                <div class="alert alert-warning">
                <p>Follow your friends here now ! </p>
                    <p class="center"><a href="#" class="btn btn-info">Follow your friends here.</a></p>
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
                                <input class="typeahead form-control" name="city" id="city"  type="text" autocomplete="off" value="" placeholder="I am in...">
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
                        </div>



                    </div>
                    <!-- /.Search section -->

                    <!-- Search results section -->
                    <div class="row">

                        <div class="col-lg-12">
<?php                       $this->widget('application.components.ConciergeToolbar'); ?>
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