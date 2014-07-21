
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<?php if ( (!empty($event->event_latitude)) && (!empty($event->event_longitude)) ) { ?>
<script>

function initialize() {

	var latitude  = <?php echo $event->event_latitude; ?>;
	var longitude = <?php echo $event->event_longitude; ?>;

    var map_canvas = document.getElementById('map_canvas');

    var map_options = {
        center: new google.maps.LatLng(latitude, longitude),
        zoom:8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    var map = new google.maps.Map(map_canvas, map_options)

}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
<?php } ?>


<style>
<!--
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
-->
</style>

<style>
#map_canvas {
	width: 600px;
	height: 500px;
}
</style>


<div class='row' id='mainpanel'>

    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">


        <!-- TODO: render Goes wierd if there is a missing image. Check for image first -->
        <div class='product-img-container' href='#'>
            <?php
            if (@GetImageSize('./' . $event->getThumbnailUrl())) {
                echo CHtml::image($event->getThumbnailUrl(), "Image", array(
                    'class' => "product-img"
                ));
            } else {
                echo CHtml::image(Yii::app()->theme->baseUrl . '/resources/images/site/no-image.jpg', "No image available", array(
                    'class' => "product-img"
                ));
            }
            ?>
        </div>

        <input type="checkbox" name="play" class="play_button" /><label for="play"><span></span></label>


    </div>

    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <strong><?php echo CHtml::Encode($event->event_title); ?></strong>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Start Date :</div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <?php echo CHtml::Encode($event->event_start_date); ?> - <?php echo CHtml::Encode($event->event_start_time); ?>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">End Date :</div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <?php echo CHtml::Encode($event->event_end_date); ?> - <?php echo CHtml::Encode($event->event_end_time); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo CHtml::Encode($event->event_description); ?>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">End Date :</div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <?php echo CHtml::Encode($event->event_address1); ?>
            <br/>
            <?php echo CHtml::Encode($event->event_address2); ?>
            <br/>
            <?php echo CHtml::Encode($event->eventCity->city_name); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo CHtml::Encode($event->event_description); ?>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Phone :</div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <?php echo CHtml::Encode($event->event_phone_no); ?>
        </div>



    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id='map_canvas'>MAP HERE</div>
    </div>

</div>