<?php

/**
 * Command Class for the shell command SyncTnEvents to copy imported
 * ...Ticket Network event records into our local list
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncTnEvents is a Yii Console command that copies imported
 * ...Ticket Network event records into our local event list.
 * ...
 * ...Imported TN events records are read from a seperate console command
 * ...process to read from a supplied database file and imported into the
 * ...<i>tn_events</i> table.
 * ...
 * ...The SyncTnEvents command will read the tn_events table
 * ...and copy data to the sites event table.
 * ...Validation is done to ensure :-
 * ...   - already excluded entries are not re-copied
 *
 * @package Commands
 * @version 1.0
 */


class SyncTnEventsCommand extends CConsoleCommand
{

    /**
     * Command main function.
     * This function will run automatically once the CConsoleCommand environment
     * ...is initialised
     *
     * @param args array command line arguements
     *
     * @return array validation rules for model attributes.
     * @access public
     */
    public function run($args)
    {

        // /////////////////////////////////////////////////////////////////////
        // Read all Imported TN Event records
        // /////////////////////////////////////////////////////////////////////
        $listTnEvents   = TnEvent::model()->findAll();

        $recordsProcessed       = 0;
        $recordsSuccessfull     = 0;

        foreach ($listTnEvents as $recTnEvent)
        {

            $recordsProcessed++;

            // ////////////////////////////////////////////////////////////////
            // Check if the eveny exists by checking the biz namea
            // ...and location? and ??  // TODO: Check with Client
            // ////////////////////////////////////////////////////////////////
            $recEvent = Event::model()->findByAttributes(
                                            array('external_event_id'       => $recTnEvent->tn_id,
                                                  'external_event_source'   => 'ticketnetwork')
                                        );

            // Do not process an existing business record
            if ($recEvent != null)
            {
                continue;
            }

            // ////////////////////////////////////////////////////////////////
            // If we are here, then we have a new record to be added.
            // ////////////////////////////////////////////////////////////////

            // ////////////////////////////////////////////////////////////////
            // Map the fields of the imported record to the business table
            // ////////////////////////////////////////////////////////////////
            $recEvent = new Event;

            $recCity   = City::model()->findByAttributes(array('city_alternate_name' => $recTnEvent->tn_city));
            if ($recCity === null)
            {
                $cityId = null;
            }
            else
            {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity->city_id;
            }

            $recEvent->event_title              = $recTnEvent->tn_event_name;
            $recEvent->event_description        = $recTnEvent->tn_event_name;
            $recEvent->event_type               = 'public';
            $recEvent->event_start_date         = $recTnEvent->tn_date;
            $recEvent->event_end_date           = $recTnEvent->tn_date;
            $recEvent->event_address1           = $recTnEvent->tn_venue;
            $recEvent->event_city_id            = $cityId;
            $recEvent->event_show_map           = 'N';
            $recEvent->is_featured              = 'N';
            $recEvent->is_popular               = 'N';
            $recEvent->event_status             = 'Active';
            $recEvent->cost                     = null;
            $recEvent->event_views              = 0;
            $recEvent->external_event_source    = 'ticketnetwork';
            $recEvent->external_event_id        = $recTnEvent->tn_id;

            $recEvent->event_tag                = EventCategory::model()->findByPK($recTnEvent->tn_child_category_id)->category_name;
            $recEvent->event_business_id        = 1;

            // TODO: Mapping of TN categories and florida.com categories is required
            // TODO: ...We are still unsure if this will be done manually or automated.
            $recEvent->event_category_id        = $recTnEvent->tn_child_category_id;


            // NOTE: The following fields from the business tables are not set
            // NOTE: ...explicitly and remain unset or use default values.
            // $recEvent->event_start_time             = '';
            // $recEvent->event_end_time             = '';
            // $recEvent->event_frequency     = 0;
            // $recEvent->event_address2       = 0;
            // $recEvent->event_street          = 0;
            // $recEvent->business_phone      = null;
            // $recEvent->event_photo                 = null;
            // $recEvent->event_business_id                 = null;
            // $recEvent->event_latitude                 = null;
            // $recEvent->event_longitude                 = null;
            // $recEvent->created_time                 = null;


            try {

                if ($recEvent->save())
                {
                    $recordsSuccessfull++;
                }
                else
                {
                    echo 'Error saving record #'.($recordsProcessed)."\n";
                    print_r($recEvent->getErrors());
                    print_r($recEvent->attributes);
                }

            } catch (Exception $error) {
                print_r($recEvent);
                print_r($error);
            }

        }


        echo "\n\nFinished.\nLoaded $recordsProcessed records.\nSucessful loads : $recordsSuccessfull\n";
        Yii::app()->end();

    }

}

?>