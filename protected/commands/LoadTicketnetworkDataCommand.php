<?php

/**
 * Command Class for the shell command LoadTicketnetworkDataCommand to load
 * ...Ticket Network data for offline usage.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * LoadTicketnetworkDataCommand is a Yii Console command that copies connects to
 * ...the Ticket Network web servives and imports various data sets for local
 * ...offline access/
 * ...
 *
 * @package Commands
 * @version 1.0
 */
if(!defined('MODE')){
    DEFINE('MODE', 'test');
}

// Yii::import("application.extensions.ticket-network.ticketnetwork.class.php");
require_once __DIR__ . '/../extensions/ticket-network/src/Exception/ExceptionInterface.php';
require_once __DIR__ . '/../extensions/ticket-network/src/Exception/CustomException.php';
require_once __DIR__ . '/../extensions/ticket-network/ticketnetwork.class.php';
require_once __DIR__ . '/../extensions/ticket-network/ticketnetwork_category.class.php';
require_once __DIR__ . '/../extensions/ticket-network/ticketnetwork_state.class.php';

require_once __DIR__ . '/../extensions/ticket-network/tnsample.php';





class LoadTicketnetworkDataCommand extends CConsoleCommand
{

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
        if (!isset($userOptions['states']))
        {
            $userOptions['states'] = 'yes';
        }
        if (!isset($userOptions['events']))
        {
            $userOptions['events'] = 'yes';
        }
        if (isset($userOptions['startdate']))
        {
            $searchStartDate    = $userOptions['startdate'];
        }
        else
        {
            $searchStartDate    = date('m/d/Y');
        }

        if (isset($userOptions['days']))
        {
            $modDate            = strtotime($searchStartDate."+ {$userOptions['days']} days");
            $searchEndDate      = date('m/d/Y',$modDate);
        }
        else
        {
            $modDate            = strtotime($searchStartDate."+ 8 days");
            $searchEndDate      = date('m/d/Y',$modDate);
        }



        $tnFactory = new TicketNetworkFactory();

        if (isset($userOptions['categories']) && ($userOptions['categories'] != 'no'))
        {

            $categoryObj = $tnFactory->create('category', $tnFactory->options());
            $listCategories = $categoryObj->send('get')->results();

            foreach ($listCategories as $itemCategory)
            {
                $modelcategory  = new TnCategory;
                $modelcategory->ChildCategoryDescription        = $itemCategory->ChildCategoryDescription;
                $modelcategory->ChildCategoryID                 = $itemCategory->ChildCategoryID;
                $modelcategory->GrandchildCategoryDescription   = $itemCategory->GrandchildCategoryDescription;
                $modelcategory->GrandchildCategoryID            = $itemCategory->GrandchildCategoryID;
                $modelcategory->ParentCategoryDescription       = $itemCategory->ParentCategoryDescription;
                $modelcategory->ParentCategoryID                = $itemCategory->ParentCategoryID;

                $modelcategory->save();

            }
        }

        if (isset($userOptions['states']) && ($userOptions['states'] != 'no'))
        {

            // TODO: Cities must be synced with our local cities tables
            $stateObj = $tnFactory->create('state', $tnFactory->options());
            $stateObj->set(array('countryID' => UNITED_STATES), 'data');
            $states = $stateObj->send('get', array('countryID' => UNITED_STATES))->results();
        }


        if (isset($userOptions['events']) && ($userOptions['events'] != 'no'))
        {

            $paramGetEvents = array(
                                'websiteConfigID'       => WEB_CONF_ID,
                                'numberOfEvents'        => null,
                                'eventID'               => null,
                                'eventName'             => '',
                                'eventDate'             => null,
                                'beginDate'             => $searchStartDate,
                                'endDate'               => $searchEndDate,
                                'venueID'               => null,
                                'venueName'             => '',
                                'stateProvDesc'         => '',
                                'stateID'               => 10,
                                'cityZip'               => '',
                                'nearZip'               => '',
                                'parentCategoryID'      => null,
                                'childCategoryID'       => null,
                                'grandchildCategoryID'  => null,
                                'performerID'           => null,
                                'performerName'         => '',
                                'noPerformers'          => null,
                                'lowPrice'              => null,
                                'highPrice'             => null,
                                'modificationDate'      => null,
                                'onlyMine'              => null,
                                'whereClause'           =>'',
                                'orderByClause'         =>''
            );

            foreach (getAllEventDetailsArray($paramGetEvents) as $key => $eventDetails) {

                // Check of the event already exists, and get ready to add it
                // ...if it does. No further action is required otherwise
                $eventModel = TnEvent::model()->findByAttributes(array('tn_id' => (int) $eventDetails->ID));
                if ($eventModel === null)
                {
                    $eventModel                             = new TnEvent;
                    $eventModel->tn_id                      = $eventDetails->ID;
                    $eventModel->tn_child_category_id       = $eventDetails->ChildCategoryID;
                    $eventModel->tn_parent_category_id      = $eventDetails->ParentCategoryID;
                    $eventModel->tn_grandchild_category_id  = $eventDetails->GrandchildCategoryID;
                    $eventModel->tn_city                    = $eventDetails->City;
                    $eventModel->tn_state_id                = $eventDetails->StateProvinceID;
                    $eventModel->tn_state_name              = $eventDetails->StateProvince;
                    $eventModel->tn_country_id              = $eventDetails->CountryID;
                    $eventModel->tn_date                    = $eventDetails->Date;
                    $eventModel->tn_display_date            = $eventDetails->DisplayDate;
                    $eventModel->tn_map_url                 = $eventDetails->MapURL;
                    $eventModel->tn_interactive_map_url     = $eventDetails->InteractiveMapURL;
                    $eventModel->tn_event_name              = $eventDetails->Name;
                    $eventModel->tn_venue                   = $eventDetails->Venue;
                    $eventModel->tn_venue_id                = $eventDetails->VenueID;
                    $eventModel->tn_venue_configuration_id  = $eventDetails->IDVenueConfigurationID;

                    if ($eventModel->save() === false)
                    {
                        echo "Error saving event to local event table.";
                        print_r($eventModel->attributes);
                        print_r($eventModel->getErrors());

                    }

                }


            };

            echo $events;
        }




        Yii::app()->end();

    }

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com TicketNetwork Event Data Import Utility (cli) (Version : 1.00)
Usage: yiic LoadTicketnetworkDataCommand [options]

where :
--categories=yes|no        - Option to load categories data. Default is {yes}.
--state=yes|no        - Option to load states data. Default is {yes}.
--events=yes|no        - Option to load states data. Default is {yes}.
--startdate={startdate}   - Inclusive start date for event search. Default is {today}.
--days={daystoload}  - Number of days of data to load. Default is 8.

EOD;

        echo $usage;
    }

}

?>