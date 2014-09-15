<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);


?>

<?php

$listEvents             = $data['listEvents'];
$listUpcomingEvents     = $data['listUpcomingEvents'];

?>

<!-- events main panel -->

<style type="text/css">

.my_event_selected  {
    display: block;
}

.invited {border:solid 3px red}

</style>

<style>

/* .event_list { */
/*     height:300px;overflow-y:auto;overflow-x:off; */
/* } */

.event_list li {
    background-clip: padding-box;
    border-radius: 4px;
    list-style-type: none;
    overflow: hidden;
    padding: 1em 0 1em 1em;
}

.event_list ul li {
    list-style: disc inside none;
    padding-left: 20px;
}

.event_list h2, .event_list p {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    margin: 0;
    padding-bottom: 0;
}
.event_list p, .event_list h2 {
    width: 360px;
}
.event_list img, .event_list h2, .event_list p {
    float: left;
}
h2 {
    font-size: 32px;
    padding-bottom: 10px;
}

/* */


.event_list li:hover
{
  background-color: #eff1f9;
  cursor: pointer;
  box-shadow: #bbbbbb;
}
</style>

<style>
<!--
#event_main {
    background:#fff;
}
-->
</style>


<!-- New Event Modal -->
<div class="modal fade" id="modalNewEvent" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
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

                    <div id="event_main">

                        <!-- Main Event area -->
                        <div class="row">

                            <!--  Event Buckets -->
                            <div class="col-sm-3 col-md-2">


                                <div class="panel panel-default margin-top-10">
                                    <div class="panel-heading">

                                    <?php if (!Yii::app()->user->isGuest) { ?>

                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h4>
                                                    <p class="center">
                                                        <a href="#" id='create_event' class="btn btn-info">Create a New Event.</a>
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

                                    <?php } ?>

                                        <div id='event_details_panel'>

                                        </div>

                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h4>
                                                    <p class="center">
                                                        Upcoming Events
                                                    </p>
                                                </h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div id='upcoming_events'>
                                                            <ul>
                                                            <?php
                                                                foreach ($listUpcomingEvents as $itemEvent) {
                                                                     echo '<li>'.
                                                                          CHtml::link(CHtml::encode($itemEvent->event_title),
                                                                                      Yii::app()->createUrl('//calendar/calendar/showevent', array('event' => $itemEvent['event_id'])),
                                                                                      array('class'=>"question-link", 'title'=>"")).
                                                                          '</li>';
                                                                }
                                                            ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </div>
                            <!--  ./Event Buckets -->

                            <!--  Event Lists -->
                            <div class="col-sm-9 col-md-10">

                                <div class="panel panel-default">


                                    <div class="panel-heading">
                                        My Events <i class="fa fa-link fa-1x"></i>
                                    </div>
                                    <div class="panel-body">


                                        <ul class="list-group event_list">


                                        <?php foreach ($listEvents as $myEvent) { ?>

                                        	<li class='myevent' rel='<?php echo $myEvent->event_id; ?>'>

                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">


                                                    <!-- TODO: render Goes wierd if there is a missing image. Check for image first -->
                                                    <div class='product-img-container' href='#'>
                                                        <?php
                                                            if(filter_var($myEvent->event_photo, FILTER_VALIDATE_URL))
                                                            {
                                                                $imageURL = $myEvent->event_photo;
                                                            }
                                                            else
                                                            {
                                                                $imageURL = Yii::app()->request->baseUrl .'/uploads/images/event/'.$myEvent->event_photo;
                                                            }
                                                        ?>
                                                        <?php echo CHtml::image($imageURL, 'Event Image', array("width"=>"180px" ,"height"=>"180px", 'id'=>'event_main_image_view')); ?>

                                                    </div>

                                                </div>

                                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <strong><?php echo CHtml::Encode($myEvent->event_title); ?></strong>
                                                    </div>

                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Start Date :</div>
                                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                            <?php echo CHtml::Encode($myEvent->event_start_date); ?> - <?php echo CHtml::Encode($myEvent->event_start_time); ?>
                                                    </div>

                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">End Date :</div>
                                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                        <?php echo CHtml::Encode($myEvent->event_end_date); ?> - <?php echo CHtml::Encode($myEvent->event_end_time); ?>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <?php echo CHtml::Encode($myEvent->event_description); ?>
                                                    </div>

                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">End Date :</div>
                                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                        <?php echo CHtml::Encode($myEvent->event_address1); ?>
                                                        <br/>
                                                        <?php echo CHtml::Encode($myEvent->event_address2); ?>
                                                        <br/>
<?php                                                   if (isset($myEvent->eventCity)) { ?>
                                                            <?php echo CHtml::Encode($myEvent->eventCity->city_name); ?>
<?php                                                   } ?>

                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <?php echo CHtml::Encode($myEvent->event_description); ?>
                                                    </div>

                                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Phone :</div>
                                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                        <?php echo CHtml::Encode($myEvent->event_phone_no); ?>
                                                    </div>

                                                    <div class="col-xs-12">
                                                        <button type='submit' class="btn btn-md btn-warning" href="<?php echo Yii::app()->createUrl('calendar/calendar/update/', array('event_id'=>$myEvent->event_id)); ?>" id='update_event'>
                                                            <i class="glyphicon glyphicon-envelope"></i>
                                                            Update Event
                                                        </button>

                                                        <button type='submit' class="btn btn-md btn-danger" href="<?php echo Yii::app()->createUrl('calendar/calendar/delete/', array('id'=>$myEvent->event_id)); ?>" id='delete_event' rel="<?php echo $myEvent->event_id; ?>">
                                                            <i class="glyphicon glyphicon-minus-sign"></i>
                                                            Delete Event
                                                        </button>

                                                    </div>

                                                </div>

                                        	</li>

                                        <?php } ?>
                                        </ul>

                                    </div>
                                    <div class="panel-footer">

                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- ./Main Event area -->

                    </div>





<?php

$local_list = City::model()->getListjson();

$baseUrl = $this->createAbsoluteUrl('/');

$neweventURL    = $baseUrl.'/calendar/calendar/newevent/';

$script = <<<EOD



    // Fix for bug with select 2 render in modal
 //   $.fn.modal.Constructor.prototype.enforceFocus = function () {};



// $("#event_city_id").select2({
//     placeholder: "I am in...",
//     allowClear: true
// });


    // /////////////////////////////////////////////////////////////////////////
    // Create new event
    // /////////////////////////////////////////////////////////////////////////
    // Launch the modal when the create new event link is clicked
    $('body').on('click', '#create_event', function(e) {


        $("#modalNewEvent").modal({

            keyboard: false,
            remote: '$neweventURL'

        });


    });

    // /////////////////////////////////////////////////////////////////////////
    // Change event details
    // /////////////////////////////////////////////////////////////////////////
    // Launch the modal when the create new event link is clicked
    $('body').on('click', '#update_event', function(e) {

        var url = $(this).attr("href");

        $("#modalNewEvent").modal({

            keyboard: false,
            remote: url

        });
    });
    //

    // /////////////////////////////////////////////////////////////////////////
    // Delete event.
    // /////////////////////////////////////////////////////////////////////////
    // Launch the modal when the create new event link is clicked
    $('body').on('click', '#delete_event', function(e) {

        $("#event_city_id").select2({
            placeholder: "I am in...",
            allowClear: true
        });

            var result = window.confirm("Do you really want to Delete the event?");
            if (result == false) {
                e.preventDefault();
                return false;
            }
            else {
                $.ajax({
                	type: 'POST',
                	url: $(this).attr("href"),
                	datatype:"json",
                	data: {event_id: $(this).attr("rel")} ,

                	success: function(data, status) {
                 	   location.reload();
                	}
            	});
                return false;
            }

    });


    $('#modalNewEvent').on('shown.bs.modal', function(e) {

        $.fn.modal.Constructor.prototype.enforceFocus = function () {};

        $("#event_city_id").select2({
            placeholder: "I am in...",
            allowClear: true
        });

    });


    // Clear the modal each time
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

EOD;

Yii::app()->clientScript->registerScript('my_event_list', $script, CClientScript::POS_READY);

?>