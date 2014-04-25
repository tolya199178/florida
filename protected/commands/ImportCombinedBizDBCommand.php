<?php

class ImportCombinedBizDBCommand extends CConsoleCommand
{

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

                    $objBusiness = new BusinessdbImport();
                    $objBusiness->attributes = $data_array;
                    $objBusiness->date_created = new CDbExpression('NOW()');
                    if ($objBusiness->save() === false)
                    {
                        echo 'Error saving record #'.($row-1)."\n";
                        print_r($objBusiness->getErrors());
                        print_r($objBusiness->attributes);
                        exit;
                    }

                }
                $row++;
            }


            $transaction->commit();
        } catch (Exception $error) {
            print_r($objBusiness);
            print_r($error);
            $transaction->rollback();
        }

        $numRecords = $row - 2;     // One for header, one for end of loop
        echo "\n\nFinished.\nLoaded $numRecords records.\n";
        Yii::app()->end();

    }

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com CSV Business Import Utility (cli) (Version : 1.00)
Usage: yiic ImportCombinedBizDB [filename] [overwrite]

where :
-filename	  {filename} - Path to CSV file to import
-overwrite	  yes|no     - Option to overwrite existing record.


EOD;

        echo $usage;
    }
}

?>