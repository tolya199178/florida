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

        date_default_timezone_set('America/New_York');

        // Process the command line options
        $resolvedArgs = $this->resolveRequest($args);
        $userOptions = $resolvedArgs[1];

        if (isset($userOptions['help']))
        {
            $this->showUsage();
            Yii::app()->end();
        }
        // Set default options or override them from the command line
        if (!isset($userOptions['categories']))
        {
            $userOptions['categories'] = 'yes';
        }

        // Set default options or override them from the command line
        if (!isset($userOptions['events']))
        {
            $userOptions['events'] = 'yes';
        }



        // /////////////////////////////////////////////////////////////////////
        // Process the Imported Categories, if required.
        // /////////////////////////////////////////////////////////////////////
        if (isset($userOptions['categories']) && ($userOptions['categories'] != 'no'))
        {
            $listTnCategories   = TnImportCategory::model()->findAll();

            foreach ($listTnCategories as $itemTnCategory)
            {

                // The TN Category entry will contains details of 3 levels of
                // ...category hierarchy. We add all three, one at a time.

                // Start with the parent
                $this->loadCategory($itemTnCategory->ParentCategoryDescription,
                                    $itemTnCategory->ParentCategoryID,
                                    null);

                // Start with the child
                $this->loadCategory($itemTnCategory->ChildCategoryDescription,
                                    $itemTnCategory->ChildCategoryID,
                                    $itemTnCategory->ParentCategoryID);

//                 // Then the grandchild
                   // NOTE: The Grandchild category reference is not unique. We will not use
                   // NOTE: ...this at this stage.
//                 $this->loadCategory($itemTnCategory->GrandchildCategoryDescription,
//                                     $itemTnCategory->GrandchildCategoryID,
//                                     $itemTnCategory->ChildCategoryID);

            }

        }



        // /////////////////////////////////////////////////////////////////////
        // Process the imported event records
        // /////////////////////////////////////////////////////////////////////

        if (isset($userOptions['events']) && ($userOptions['events'] != 'no'))
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

                echo 'Processing event record #' . $recordsProcessed . ' : ' . $recTnEvent['tn_event_name']
                . ' (local_id:' . $recTnEvent['tn_event_id'] . ', tn_id:'. $recTnEvent['tn_id'].').';


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
                    echo '... .Record already loaded. No further processing required.' . "\n";
                    continue;
                }

                // ////////////////////////////////////////////////////////////////
                // If we are here, then we have a new record to be added.
                // ////////////////////////////////////////////////////////////////
                $recEvent = new Event;


                // ////////////////////////////////////////////////////////////////
                // Map the fields of the imported record to the business table. We
                // ...look in the city name, but also search the alternate name,
                // ...which is a comma-delimited list of alternate city names.
                // ////////////////////////////////////////////////////////////////

                $citySearchCriteria     = new CDbCriteria();

                $citySearchCriteria->condition = "FIND_IN_SET(:city, CONCAT(city_name,',',city_alternate_name))";
                $citySearchCriteria->params    = array(':city'=>$recTnEvent->tn_city);

                $recCity   = City::model()->find($citySearchCriteria);
                if ($recCity === null)
                {
                    $cityId = null;
                    echo "\t" . '*** WARNING: No match for city name ' .
                         $recTnEvent->tn_city . '. Setting city name to NULL ***' . "\n";
                }
                else
                {
                    // NOTE: This will result in an exception due to a referential integrity
                    // NOTE: ...check with business.business_city_id field.
                    // NOTE: ...This is however, our intented behaviour.
                    $cityId = $recCity->city_id;
                }

                // /////////////////////////////////////////////////////////////////
                // Get the event category details. These will be copied over to the
                // ...keyword field for the event.
                // /////////////////////////////////////////////////////////////////
                $tagEvents                  = array();

                $modelParentCategory = EventCategory::model()->findByAttributes(array(
                    'external_reference' => $recTnEvent->tn_parent_category_id,
                    'external_source' => 'ticketnetwork'
                ));
                if ($modelParentCategory)
                {
                    $tagEvents[]            = $modelParentCategory->category_name;
                }

                $modelChildCategory = EventCategory::model()->findByAttributes(array(
                    'external_reference' => $recTnEvent->tn_child_category_id,
                    'external_source' => 'ticketnetwork'
                ));
                if ($modelParentCategory)
                {
                    $tagEvents[]            = $modelChildCategory->category_name;
                }

                // NOTE: The Grandchild category reference is not unique. We will not use
                // NOTE: ...this at this stage.
//                 $modelGrandChildCategory = EventCategory::model()->findByAttributes(array(
//                     'external_reference' => $recTnEvent->tn_grandchild_category_id,
//                     'external_source' => 'ticketnetwork'
//                 ));
//                 if ($modelGrandChildCategory)
//                 {
//                     $tagEvents[]          = $modelGrandChildCategory->category_name;
//                 }



                $recEvent->event_title              = $recTnEvent->tn_event_name;
                $recEvent->event_description        = $recTnEvent->tn_event_name;
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

                $recEvent->event_tag                = implode(",", $tagEvents);

                // We assign the event to teh control business.
                $recEvent->event_business_id        = 1;

                $recEvent->event_category_id        = $modelChildCategory->category_id;

                $recEvent->event_photo              = $recTnEvent->tn_map_url;






                // NOTE: The following fields from the business tables are not set
                // NOTE: ...explicitly and remain unset or use default values.
                // $recEvent->event_start_time              = '';
                // $recEvent->event_end_time                = '';
                // $recEvent->event_frequency               = 0;
                // $recEvent->event_address2                = 0;
                // $recEvent->event_street                  = 0;
                // $recEvent->business_phone                = null;

                // $recEvent->event_latitude                = null;
                // $recEvent->event_longitude               = null;


                try {

                    if ($recEvent->save())
                    {
                        $recordsSuccessfull++;
                        echo 'Record saved.'."\n";
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


            echo "\n\nFinished.\nLoaded $recordsProcessed records.\nSuccessful loads : $recordsSuccessfull\n";
            Yii::app()->end();
        }


    }

    /**
     * Get the category record.
     * Add the category if it does not exist.
     *
     * @param string $tnCategoryName The category name obtained from TN
     * @param integer $tnCategoryId The category id obtained from TN
     * @param string $tnParentCategoryId The parent category id obtained from TN
     *
     * @return boolean record save result
     * @access private
     */
    private function loadCategory($tnCategoryName, $tnCategoryId, $tnParentCategoryId = null)
    {

         // /////////////////////////////////////////////////////////////////////
         // Check to see that the local category does not alreday exist
         // /////////////////////////////////////////////////////////////////////
        $modelCategory = EventCategory::model()
                                      ->findByAttributes(array(
                                            'external_reference'=>$tnCategoryId,
                                            'external_source'=>'ticketnetwork'
                                        ));


        if ($modelCategory === null)
        {

            // /////////////////////////////////////////////////////////////////
            // If we are given a parent-id, try and find the corresponding
            // ...entry in event_category table.
            // /////////////////////////////////////////////////////////////////
            $modelParentEventCategory = EventCategory::model()
            ->findByAttributes(array(
                'external_reference'=>$tnParentCategoryId,
                'external_source'=>'ticketnetwork'
            ));

            if ($modelParentEventCategory!=null)
            {
                $eventcategoryParentId = $modelParentEventCategory->category_id;
            }
            else
            {
                $eventcategoryParentId = null;
            }

            $modelCategory  = new EventCategory;

            $modelCategory->category_name        = $tnCategoryName;
            $modelCategory->category_description = $tnCategoryName;
            $modelCategory->parent_id            = $eventcategoryParentId;
            $modelCategory->external_reference   = $tnCategoryId;
            $modelCategory->external_source      = 'ticketnetwork';

            if ($modelCategory->save() === false)
            {
                echo 'Error saving category '.$tnCategoryName."\n";
                print_r($modelCategory);
                return false;
            }

        }

        return true;

    }

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com TicketNetwork Data Sync Utility (cli) (Version : 1.00)
Usage: yiic SyncTnEventsCommand [options]

where :
--categories=yes|no        - Option to load categories data. Default is {yes}.
--events=yes|no        - Option to load states data. Default is {yes}.
EOD;

        echo $usage;
    }

}
?>