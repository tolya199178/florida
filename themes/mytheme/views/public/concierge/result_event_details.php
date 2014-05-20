						<!-- COUNTRY ITEM -->

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<div class="thumbnail">

                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                            <?php
                            $str = strlen($eventItem['event_title']) < 45 ? $eventItem['event_title'] : substr($eventItem['event_title'], 0, 41) . "...";
                            $url = array("/booking/getmyticket", 'id' => $eventItem['event_id']);
                            echo CHtml::link($str, $url, array("title" => $eventItem['event_title']))
                            ?>
                                        </div>
                                        <div class="panel-body">
                                            <div class="event_detail">

                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <table class="_ws_ajax_events">
                <tr>
<!--                     <td> -->
<!--                         <h4> -->
                            <?php
//                             $str = strlen($eventItem['event_title']) < 45 ? $eventItem['event_title'] : substr($eventItem['event_title'], 0, 41) . "...";
//                             $url = array("/booking/getmyticket", 'id' => $eventItem['event_id']);
//                             echo CHtml::link($str, $url, array("title" => $eventItem['event_title']))
//                             ?>
<!--                         </h4> -->
<!--                     </td> -->
<!--                 </tr> -->
                <tr>
                    <td colspan="2">
                        <?php
                        $mapURL = empty($eventItem['tn_map_url'])? "/EventImages/MapComingSoon.jpg" : $eventItem['tn_interactive_map_url'];
                        echo CHtml::image($mapURL, "Event", array('height' => 150, 'width' => 275)); ?>
                    </td>
                </tr>
                <tr>
                    <td><p><?php echo $eventItem['tn_city']; ?></p></td>
                </tr>
                <tr>
                    <td><p><?php echo $eventItem['tn_display_date']; ?></p></td>
                </tr>
                <tr>
                    <td>
                        <p><?php echo $eventItem['tn_venue']; ?></p>
                        <?php if(isset($type) ){ ?>
                        <span class="small-tags">
                            <span  class="label"> <?php echo $eventItem['event_tag']; ?></span>
                        </span>
                        <?php } ?>
                    </td>
                </tr>
            </table>
                                                </div>



                                            </div>
                                        </div>
                                    </div>


								</div>

							</div>
							<!-- /COUNTRY ITEM -->


