<?php

class ImportBusinessCSVCommand extends CConsoleCommand
{

    public function run($args)
    {
        if (empty($args[0])) {
            $this->showUsage();
            exit();
        }

        $csvFileName = $args[0];


        try {
            // $transaction = Yii::app()->db->beginTransaction();
            $handle = fopen($csvFileName, "r");
            $row = 1;

            $business_import_command = Yii::app()->db->createCommand();

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

                   // print_r($data_array);exit;

                   $business_import_command->insert('manta_business_import', $data_array);

                    //  print_r($business_import_command->text);exit;
                }
                $row++;
            }


        //    $transaction->commit();
        } catch (Exception $error) {
            print_r($objHotel);
       //     $transaction->rollback();
        }

        $numRecords = $row - 2;     // One for header, one for end of loop
        echo "\n\nFinished.\nLoaded $numRecords records.\n";
        Yii::app()->end();

    }

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com CSV Business Import Utility (cli) (Version : 1.00)
Usage: yiic ImportBusinessCSV [filename] [overwrite]

where :
-filename	  {filename} - Path to CSV file to import
-overwrite	  yes|no     - Option to overwrite existing record.


EOD;

        echo $usage;
    }
}

?>