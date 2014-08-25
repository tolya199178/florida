<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<?php if ( (!empty($event->event_latitude)) && (!empty($event->event_longitude)) ) { ?>
<script>

// function initialize() {

//	var latitude  = < ? php echo $ event->event_latitude; ? >;
//	var longitude = < ? php echo $ event->event_longitude; ? >;

//     var map_canvas = document.getElementById('map_canvas');

//     var map_options = {
//         center: new google.maps.LatLng(latitude, longitude),
//         zoom:8,
//         mapTypeId: google.maps.MapTypeId.ROADMAP
//     }

//     var map = new google.maps.Map(map_canvas, map_options)

// }

// google.maps.event.addDomListener(window, 'load', initialize);

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
	width: 100%;
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



   <div class="modal-dialog event-details-modal1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Event Details</h4>

            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class='row'>

                    <?php echo CHtml::link('Make a booking', Yii::app()->createUrl('calendar/calendar/makebooking/', array('id' => $event->event_id  )), array('title' => $event->event_title)); ?>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">


                        <div class='product-img-container' href='#'>
                            <a href="#" class='thumbnail'>
<?php
                                if (!empty($event->event_photo))
                                {
                                    if(filter_var($event->event_photo, FILTER_VALIDATE_URL))
                                    {
                                        $imageURL = $event->event_photo;
                                    }
                                    else
                                    {
                                        if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$event->event_photo))
                                        {
                                            $imageURL = Yii::app()->request->baseUrl .'/uploads/images/business/'.$event->event_photo;
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

                        <div class="map_box">

                            <?php $this->renderPartial('modal/event_map', array('event'=>$event)); ?>

                        </div>
                        <hr>
<!--                         <div id='map_canvas'>MAP HERE</div> -->
                    </div>

                </div>


            </div>

        </div>
    </div>


