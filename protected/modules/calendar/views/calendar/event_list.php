        <?php

             foreach ($listEvents as $objEvent)
             {
                 $this->renderPartial('event_thumbnail', array('event' => $objEvent));
             }

        ?>