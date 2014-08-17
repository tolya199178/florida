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
require_once __DIR__ . '/../extensions/ticket-network/ticketnetwork_venue.class.php';

require_once __DIR__ . '/../extensions/ticket-network/tnsample.php';

require_once __DIR__ . 'services_utils.php';





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
        if (!isset($userOptions['venues']))
        {
            $userOptions['venues'] = 'yes';
        }
        if (!isset($userOptions['performers']))
        {
            $userOptions['performers'] = 'yes';
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

                        // Go ahead and read the next ine anyway.
                        continue;

                    }

                    // Getting here means a successful event record save. Save the venue details
                    $this->getVenueDetails($eventDetails->VenueID);

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

    /**
     * Save the venue details
     *
     * @param integer venue_id The TN venue reference.
     *
     * @return boolean save result
     * @access public
     */
    private function getVenueDetails($venueId)
    {

        // Get the venue details
        $servicesHost       = "tnwebservices-test.ticketnetwork.com";
        $servicesQuery      = "/tnwebservice/v3.1/tnwebservicestringinputs.asmx/GetVenue";

        $servicesParameters = http_build_query(
            array('websiteConfigID'  => WEB_CONF_ID,
                  'venueID'          => $venueId));

        $serviceRequest     = $servicesHost.$servicesQuery.'?'.$servicesParameters;

        $venueResults       = sendGetRequest($serviceRequest);
        $venueXmlResults    = simplexml_load_string($venueResults);
        $allVenues          = simpleXMLToArray($venueXmlResults);
        $venuDetails        = $allVenues['Venue'];

        $modelTnVenue       = TnImportVenue::model()->findByAttributes(array('tn_ID'=>$venueId));

        if ($modelTnVenue)      // Already exists
        {
            return true;
        }
        else                    // Not found
        {
            // Save the venue details
            $modelTnVenue                   = new TnImportVenue;

            $modelTnVenue->tn_ID            = ((!empty($venuDetails['ID']))?$venuDetails['ID']:null);
            $modelTnVenue->tn_Name          = ((!empty($venuDetails['Name']))?$venuDetails['Name']:null);
            $modelTnVenue->tn_Street1       = ((!empty($venuDetails['Street1']))?$venuDetails['Street1']:null);
            $modelTnVenue->tn_Street2       = ((!empty($venuDetails['Street2']))?$venuDetails['Street2']:null);
            $modelTnVenue->tn_StateProvince = ((!empty($venuDetails['StateProvince']))?$venuDetails['StateProvince']:null);
            $modelTnVenue->tn_City          = ((!empty($venuDetails['City']))?$venuDetails['City']:null);
            $modelTnVenue->tn_Country       = ((!empty($venuDetails['Country']))?$venuDetails['Country']:null);
            $modelTnVenue->tn_BoxOfficePhone = ((!empty($venuDetails['BoxOfficePhone']))?$venuDetails['BoxOfficePhone']:null);
            $modelTnVenue->tn_Directions    = ((!empty($venuDetails['Directions']))?$venuDetails['Directions']:null);
            $modelTnVenue->tn_Parking       = ((!empty($venuDetails['Parking']))?$venuDetails['Parking']:null);
            $modelTnVenue->tn_PublicTransportation = ((!empty($venuDetails['PublicTransportation']))?$venuDetails['PublicTransportation']:null);
            $modelTnVenue->tn_URL           = ((!empty($venuDetails['URL']))?$venuDetails['URL']:null);
            $modelTnVenue->tn_ZipCode       = ((!empty($venuDetails['ZipCode']))?$venuDetails['ZipCode']:null);
            $modelTnVenue->tn_Capacity      = ((!empty($venuDetails['Capacity']))?$venuDetails['Capacity']:null);
            $modelTnVenue->tn_ChildRules    = ((!empty($venuDetails['ChildRules']))?$venuDetails['ChildRules']:null);
            $modelTnVenue->tn_Rules         = ((!empty($venuDetails['Rules']))?$venuDetails['Rules']:null);
            $modelTnVenue->tn_Notes         = ((!empty($venuDetails['Notes']))?$venuDetails['Notes']:null);
            $modelTnVenue->tn_NumberOfConfigurations = ((!empty($venuDetails['NumberOfConfigurations']))?$venuDetails['NumberOfConfigurations']:null);
            $modelTnVenue->WillCall         = ((!empty($venuDetails['WillCall']))?$venuDetails['WillCall']:null);

            if ($modelTnVenue->save())
            {
                // Saved the venue ok. Get the venue configuration file
                $this->getVenueConfigurationDetails($venueId);
            }
            else
            {
                echo 'Error saving venue details for venue id : '.$venuDetails['ID'].'. Continuing despite error';
            }
        }


    }

    /**
     * Save the venue details
     *
     * @param integer venue_id The TN venue reference.
     *
     * @return boolean save result
     * @access public
     */
    private function getVenueConfigurationDetails($venueId)
    {

        // Get the venue details
        $servicesHost       = "tnwebservices-test.ticketnetwork.com";
        $servicesQuery      = "/tnwebservice/v3.1/tnwebservicestringinputs.asmx/GetVenueConfigurations";

        $servicesParameters = http_build_query(
            array('websiteConfigID'  => WEB_CONF_ID,
                  'venueID'          => $venueId));

        $serviceRequest         = $servicesHost.$servicesQuery.'?'.$servicesParameters;

        $venueResults           = sendGetRequest($serviceRequest);
        $venueXmlResults        = simplexml_load_string($venueResults);
        $allVenueConfigurations = simpleXMLToArray($venueXmlResults);

        $lstVenueConfigurations = $allVenueConfigurations['VenueConfiguration'];

        foreach ($lstVenueConfigurations as $itemVenueConfiguration)
        {
            $modelVenueConfiguration                        = new TnImportVenueConfiguration;
            $modelVenueConfiguration->tn_ID                 = ((!empty($itemVenueConfiguration['ID']))?$itemVenueConfiguration['ID']:null);
            $modelVenueConfiguration->tn_Capacity           = ((!empty($itemVenueConfiguration['Capacity']))?$itemVenueConfiguration['Capacity']:null);
            $modelVenueConfiguration->tn_MapSite            = ((!empty($itemVenueConfiguration['MapSite']))?$itemVenueConfiguration['MapSite']:null);
            $modelVenueConfiguration->tn_MapURL             = ((!empty($itemVenueConfiguration['MapURL']))?$itemVenueConfiguration['MapURL']:null);
            $modelVenueConfiguration->tn_VenueID            = ((!empty($itemVenueConfiguration['VenueID']))?$itemVenueConfiguration['VenueID']:null);
            $modelVenueConfiguration->tn_TypeID             = ((!empty($itemVenueConfiguration['TypeID']))?$itemVenueConfiguration['TypeID']:null);
            $modelVenueConfiguration->tn_TypeDescription    = ((!empty($itemVenueConfiguration['TypeDescription']))?$itemVenueConfiguration['TypeDescription']:null);

            if ($modelVenueConfiguration->save() === false)
            {
                echo 'Error saving venue configuration details for venue id : '.$venueId.'. Continuing despite error';
            }

        }

    }

}



?>