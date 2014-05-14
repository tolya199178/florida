<?php

/**
 * Command Class for the shell command SyncGetYourGuide to copy imported
 * ...GetYourGuide records into our local list
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncGetYourGuide is a Yii Console command that copies imported
 * ...GetYourGuide tour records into our local list for offline usage.
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


class SyncGetYourGuideCommand extends CConsoleCommand
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
        $listTours   = GetyourguideImport::model()->findAll();

        $recordsProcessed       = 0;
        $recordsSuccessfull     = 0;

        foreach ($listTours as $recGygTour)
        {

            $recordsProcessed++;

            // ////////////////////////////////////////////////////////////////
            // Check if the eveny exists by checking the biz namea
            // ...and location? and ??  // TODO: Check with Client
            // ////////////////////////////////////////////////////////////////
            $recTour = GetyourguideProduct::model()->findByAttributes(
                                                        array('gyg_id' => $recGygTour->getyourguide_external_id)
                                                    );

            // Do not process an existing business record
            if ($recTour != null)
            {
                continue;
            }

            // ////////////////////////////////////////////////////////////////
            // If we are here, then we have a new record to be added.
            // ////////////////////////////////////////////////////////////////

            // ////////////////////////////////////////////////////////////////
            // Map the fields of the imported record to the business table
            // ////////////////////////////////////////////////////////////////
            $recTour = new GetyourguideProduct;

            // ////////////////////////////////////////////////////////////////
            // Tours are listed at different locations. We extract the locations
            // ...and place them in a comma-delimited list.
            // ////////////////////////////////////////////////////////////////
            $lstDestinations        = array();
            $gygDestination         = unserialize($recGygTour->destination);
            $gygListLocations       = $gygDestination['locations']['location'];
            foreach ($gygListLocations as $itemGygLocation)
            {
                $lstDestinations[]  = trim($itemGygLocation[0]);
            }

            // ////////////////////////////////////////////////////////////////
            // Prices are listed in multiple currencies. We are only interested
            // ...in the USD one.
            // ////////////////////////////////////////////////////////////////
            $usdPrice               = 0;
            $gygPriceList           = unserialize($recGygTour->price);
            foreach ($gygPriceList as $itemPrice)
            {
                if ($itemPrice['currency'] == 'USD')
                {
                    $usdPrice       = $itemPrice[0];
                }
            }


            $recTour->gyg_id                    = $recGygTour->getyourguide_external_id;
            $recTour->gyg_last_modify_time      = $recGygTour->last_modification_datetime;
            $recTour->gyg_title                 = $recGygTour->title;
            $recTour->gyg_abstract              = $recGygTour->abstract;
            $recTour->gyg_destination_list      = implode(",", $lstDestinations);;
            $recTour->gyg_price                 = $usdPrice;
            $recTour->gyg_price_description     = $recGygTour->prices_description;
            $recTour->gyg_rating                = $recGygTour->rating;
            $recTour->gyg_url                   = $recGygTour->url;
            $recTour->gyg_language              = $recGygTour->language;


            try {

                if ($recTour->save())
                {
                    $recordsSuccessfull++;
                }
                else
                {
                    echo 'Error saving record #'.($recordsProcessed)."\n";
                    print_r($recTour->getErrors());
                    print_r($recTour->attributes);
                }

            } catch (Exception $error) {
                print_r($recTour);
                print_r($error);
            }

        }


        echo "\n\nFinished.\nLoaded $recordsProcessed records.\nSucessful loads : $recordsSuccessfull\n";
        Yii::app()->end();

    }

}

?>