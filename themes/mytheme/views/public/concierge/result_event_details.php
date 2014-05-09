<?php foreach ($data as $eventItem) { ?>
    <div class="col-md-4 unstyled results">
        <div class="box article">
            <table class="_ws_ajax_events">
                <tr>
                    <td>
                        <h4>
                            <?php
                            $str = strlen($eventItem['event_title']) < 45 ? $eventItem['event_title'] : substr($eventItem['event_title'], 0, 41) . "...";
                            $url = array("/booking/getmyticket", 'id' => $eventItem['event_id']);
                            echo CHtml::link($str, $url, array("title" => $eventItem['event_title']))
                            ?>
                        </h4>
                    </td>
                </tr>
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
<?php } ?>
