<?php
/**
 * Command Class for the shell command ImportCityList to import the list of
 * ...cities from the MaxMind cities list and load them onto the city table.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * ImportCityList is a Yii Console script that imports the maxmind supplies
 * ...list of cities and loads them onto the {{cities}} table.
 * ...
 * ...Already existing records will be ignored and reported by default. The
 * ...'overwrite' option can be used to overwrite existing records with data
 * ...from the CSV file. In this case, the existing record will be UPDATEd.
 * ...
 * ...A fixed CSV format is assumed:
 * ...  - geoname_id,
 * ...  - continent_code,
 * ...  - continent_name,
 * ...  - country_iso_code,
 * ...  - country_name,
 * ...  - subdivision_iso_code,
 * ...  - subdivision_name,
 * ...  - city_name,
 * ...  - metro_code,
 * ...  - time_zone
 * ...
 * @package Commands
 * @version 1.0
 */

class ImportCityListCommand extends CConsoleCommand
{

    /**
     * Command main function.
     * This function will run automatically once the CConsoleCommand environment
     * ...is initialised
     *
     * @param args array command line arguements
     *
     * @return <none>.
     * @access public
     */
   public function run($args)
    {
        if (empty($args[0])) {
            $this->showUsage();
            exit();
        }

        $colIndexsvFileName        = $args[0];

        $optionOverwrite    = (isset($args[1]) && ($args[1] == '--overwrite'))?true:false;

        $rowsRead           = 0;
        $rowsProcessed      = 0;


        try {
            $transaction = Yii::app()->db->beginTransaction();
            $handle = fopen($colIndexsvFileName, "r");

            while ( ($data = fgetcsv($handle, null, ",") ) !== FALSE )
            {

                $rowsRead++;

                $fieldCount = count($data);
                if ($rowsRead == 1)
                {
                    //Header line
                    for ($colIndex=0; $colIndex < $fieldCount; $colIndex++)
                    {
                        $header_array[$colIndex] = $data[$colIndex];
                    }
                    continue;
                }


                //Data line
                for ($colIndex=0; $colIndex < $fieldCount; $colIndex++)
                {
                    $recImportedCity[$header_array[$colIndex]] = $data[$colIndex];
                }

                // Ignore the record if it is not part of state.
                if ($recImportedCity['subdivision_iso_code'] != 'FL')
                {
                    echo '** Ignoring record #'.($rowsRead-1).
                         ' ('.$recImportedCity['city_name'].') due to invalid state record '.
                         $recImportedCity['subdivision_iso_code'].".\n";
                    continue;
                }

                // Ignore the record if it is not part of state.
                if (empty($recImportedCity['city_name']))
                {
                    echo '*** Ignoring record #'.($rowsRead-1).
                    ' ('.$recImportedCity['city_name'].') due to invalid city name.'."\n";
                    continue;
                }

                echo 'Reading record #'.($rowsRead-1).' : '.$recImportedCity['city_name'].'. ';

                // Search for existing city record
                $objCity = City::model()->findByAttributes(array('city_name' => $recImportedCity['city_name']));

                // Create a new empty record if the city was not found.
                if ($objCity === null)
                {
                    $objCity = new City;
                }

                $objCity->attributes = array('city_name'            => $recImportedCity['city_name'],
                                             'city_alternate_name'  => $recImportedCity['city_name'],
                                             'state_id'             => '1',
                                             'is_featured'          => 'N',
                                             'time_zone'            => null,
                                             'isactive'             => 'N',
                                             'description'          => 'Florida Control City - not used as valid data city',
                                             'more_information'     => '...imported from maxmind...',
                                             'image'                => null,
                                             'latitude'             => null,
                                             'longitude'            => null
                            );

                if ( ($objCity->isNewRecord == true) ||
                     (($objCity->isNewRecord == false) && ($optionOverwrite === true)) )
                {
                    if ($objCity->save() === false)
                    {
                        echo "\n".'*** Error saving record #'.($rowsRead-1)."\n";
                        print_r($objCity->getErrors());
                        print_r($objCity->attributes);

                        // TODO: Uncomment this if you want the program to stop of save failure
                        // Yii::app()->end();
                    }
                    else
                    {
                        echo 'Record saved **.'."\n";
                        $rowsProcessed++;
                    }
                }
                else
                {
                    echo 'Record not saved.'."\n";
                }

            }


            $transaction->commit();
        } catch (Exception $error) {
            print_r($objCity);
            print_r($error);
            $transaction->rollback();
        }

        $numRecords = $rowsRead-1;     // Skip header in count
        echo "\n\nFinished.\nRead $numRecords records. Processed $rowsProcessed records successfully.\n";
        Yii::app()->end();

    }

    /**
     * Provide text help on command usage.
     *
     * @param <none> <none>
     *
     * @return <none>.
     * @access private
     */
    private function showUsage()
    {
        $usage = <<<EOD
Florida.com CSV City Import (from Maxmind) Utility (cli) (Version : 1.00)
Usage: yiic ImportCityList [filename] [overwrite]

where :
-filename	  {filename}    - Path to CSV file to import
-overwrite	  '--overwrite' - Option to overwrite existing record.


EOD;

        echo $usage;
    }
}

?>