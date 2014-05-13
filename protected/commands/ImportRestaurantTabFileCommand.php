<?php

class ImportRestaurantTabFileCommand extends CConsoleCommand
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

        $csvFileName = $args[0];


        try {
            $transaction = Yii::app()->db->beginTransaction();
            $handle = fopen($csvFileName, "r");
            $row = 1;

            while ( ($data = fgetcsv($handle, null, "\t") ) !== FALSE )
            {

                $number_of_fields = count($data);
                if ($row == 1)
                {
                    //Header line
                    for ($c=0; $c < $number_of_fields; $c++)
                    {
                        $header_array[$c] = $data[$c];
                    }
                }
                else
                {
                    //Data line
                    for ($c=0; $c < $number_of_fields; $c++)
                    {
                        $data_array[$header_array[$c]] = $data[$c];
                    }

                    $objRestaurant = new RestaurantImport();
                    $objRestaurant->attributes = $data_array;
                    if ($objRestaurant->save() === false)
                    {
                        echo 'Error saving record #'.($row-1)."\n";
                        print_r($objRestaurant->getErrors());
                        print_r($objRestaurant->attributes);
                        exit;
                    }

                }
                $row++;
            }


            $transaction->commit();
        } catch (Exception $error) {
            print_r($objRestaurant);
            print_r($error);
            $transaction->rollback();
        }

        $numRecords = $row - 2;     // One for header, one for end of loop
        echo "\n\nFinished.\nLoaded $numRecords records.\n";
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
Florida.com CSV Restuarant.com Import Utility (cli) (Version : 1.00)
Usage: yiic ImportRestaurantTabFile [filename] [overwrite]

where :
-filename	  {filename} - Path to CSV file to import
-overwrite	  yes|no     - Option to overwrite existing record.


EOD;

        echo $usage;
    }
}

?>