<?php

/**
 * Command Class for the shell command SyncMantaImportsWithBizTable to copy imported
 * ...business records into the list of usable business records.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncMantaImportsWithBizTable is a Yii Console command that copies imported
 * ...Manta business records into the list of usable business records.
 * ...
 * ...Imported business records are read from a seperate console command
 * ...process to read from a supplied database file and imported into the
 * ...<i>imported_business</i> table.
 * ...
 * ...The SyncMantaImportsWithBizTable command will read the imported_business table
 * ...and copy data to the sites business table.
 * ...Validation is done to ensure :-
 * ...   - only records of specific categories are copied
 * ...   - already excluded entries are not re-copied
 * ...   - the imported_business table is updated to reflect the synced records
 *
 * @package Commands
 * @version 1.0
 */


class SyncMantaImportsWithBizTableCommand extends CConsoleCommand
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

        /*
         * Due to the large number of iterations, we microsleep to prevent cpu hogs
         */
       // usleep(100000);

        ini_set('memory_limit', '-1');

        // /////////////////////////////////////////////////////////////////////
        // Read all ImportedBusiness records
        // /////////////////////////////////////////////////////////////////////

        $dataProvider = new CActiveDataProvider('MantaBusinessImport');
        $providerIterator = new CDataProviderIterator($dataProvider, (int) 1000);


        $recordsProcessed       = 0;
        $recordsSuccessfull     = 0;

        // Set up a top level category for Manta
        $toplevelCategoryId     = $this->addCategory('Manta');

        $qryDisableKeyChecks = Yii::app()->db->createCommand("SET foreign_key_checks = 0;")->execute();

        $optionOverwrite = false;


        echo "\n";

        foreach($providerIterator as $recImportedBusiness)
        {

            $recordsProcessed++;

            $rowOutput = 'Processing import record for ' . $recImportedBusiness->company_name;

            // ////////////////////////////////////////////////////////////////
            // For now, we just write records without checking that they
            // already exist;
            // ////////////////////////////////////////////////////////////////

            if ($optionOverwrite === false)
            {
                // ////////////////////////////////////////////////////////////////
                // Check if the business exists by checking the biz name
                // ...and location? and ??  // TODO: Check with Client
                // ////////////////////////////////////////////////////////////////
                $recBusiness = Yii::app()->db->createCommand()
                                         ->select('business_id')
                                         ->from('tbl_business')
                                         ->where('business_name=:business_name AND image=:image',
                                                array(':business_name'=>$recImportedBusiness->company_name,
                                                      ':image'=>$recImportedBusiness->manta_url))
                                         ->limit('1')
                                         ->queryRow();

                if ($recBusiness != false)
                {
                    $rowOutput .= ' ** Record already exists at position ' . $recordsProcessed;
                    $rowOutput .= ' ** Ingoring.' . "\n";

                    // /////////////////////////////////////////////////////////////////
                    // Log the row putput
                    // /////////////////////////////////////////////////////////////////
                    $rowLogEntry = Yii::app()->db->createCommand()->insert('batch_log',
                                                        array('tag'     => 'manta_import',
                                                            'message' => $rowOutput
                                                        ));

                    continue;
                }
            }

            // NOTE: Use this trick to restart the sync job. Once we reach here. Set the  option to
            // NOTE: ...TRUE for all proc
            $optionOverwrite = true;


            // ////////////////////////////////////////////////////////////////
            // If we are here, then we have a new record to be added.
            // ////////////////////////////////////////////////////////////////

            // ////////////////////////////////////////////////////////////////
            // Map the fields of the imported record to the business table
            // ////////////////////////////////////////////////////////////////
            $recBusiness = new Business;

            $recCity = Yii::app()->db->createCommand()
                                ->select('city_id, city_name')
                                ->from('tbl_city')
                                ->where('city_name=:city_name', array(':city_name'=>$recImportedBusiness->city))
                                ->limit('1')
                                ->queryRow();

            if ($recCity === false)
            {
                $rowOutput .= ' (** No city record for imported city ' . $recImportedBusiness->city . ' **)';
                $cityId = null;
            }
            else
            {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity['city_id'];
            }

            $recBusiness->business_name                     = $recImportedBusiness->company_name;
            $recBusiness->business_address1                 = $recImportedBusiness->address;
            $recBusiness->business_address2                 = null;
            $recBusiness->business_city_id                  = $cityId;
            $recBusiness->business_zipcode                  = $recImportedBusiness->zip;
            $recBusiness->business_phone_ext                = null;
            $recBusiness->business_phone                    = substr($recImportedBusiness->phone, 0, 16);
            $recBusiness->business_email                    = $recImportedBusiness->email;
            $recBusiness->business_website                  = $recImportedBusiness->website;
            $recBusiness->business_description              = null;

            // TODO: look into this.
            $recBusiness->image                             = $recImportedBusiness->manta_url;

            $recBusiness->business_keywords                 = join(",", array($recImportedBusiness->keywords,
                                                                              $recImportedBusiness->industry));

            $recBusiness->claim_status                      = 'Unclaimed';
            $recBusiness->claim_processing_time             = null;
            $recBusiness->claimed_by                        = null;
            $recBusiness->claim_rejection_reason            = null;
            $recBusiness->is_active                         = 'Y';
            $recBusiness->is_featured                       = 'N';
            $recBusiness->is_closed                         = 'N';
            $recBusiness->latitude                          = $recImportedBusiness->latitude;
            $recBusiness->longitude                         = $recImportedBusiness->longitude;
            $recBusiness->contact                           = $recImportedBusiness->contact;
            $recBusiness->opening_time                      = $recImportedBusiness->businesshours;
            $recBusiness->import_reference                  = 'manta';
            $recBusiness->import_source                     = $recImportedBusiness->import_record_id;


            // NOTE: The following fields from the business tables are not set
            // NOTE: ...explicitly and remain unset or use default values.
            // $recBusiness->business_allow_review             = '';
            // $recBusiness->business_allow_rating             = '';
            // $recBusiness->add_request_processing_status     = 0;
            // $recBusiness->add_request_processing_time       = 0;
            // $recBusiness->add_request_processed_by          = 0;
            // $recBusiness->add_request_rejection_reason      = null;
            // $recBusiness->activation_status                 = null;


            // NOTE: The following fields from the imported record are not
            // ...copied over to the business tables
            // `brands` int(11) DEFAULT NULL,
            // `breadcrumbs` int(11) DEFAULT NULL,


            try
            {

                if ($recBusiness->save())
                {

                    $rowOutput .= " ** Record saved for {$recImportedBusiness->company_name}. **\n";

                    $recordsSuccessfull++;

                    // /////////////////////////////////////////////////////////
                    // Add the business categories
                    // /////////////////////////////////////////////////////////
                    $subCategoryId      = $this->addCategory($recImportedBusiness->category, $toplevelCategoryId);
                    $subSubCategoryId   = $this->addCategory($recImportedBusiness->sub_category, $subCategoryId);


                    // $this->assignCategoryToBiz($recBusiness->business_id, $subCategoryId);
                    $this->assignCategoryToBiz($recBusiness->business_id, $subSubCategoryId);

                }
                else
                {
                    $rowOutput .= 'Error saving record #'.($recordsProcessed)."\n";
                    print_r($recBusiness->getErrors());
                    print_r($recBusiness->attributes);
                    print_r($recImportedBusiness->attributes);
                }


            } catch (Exception $error)
            {
                print_r($recBusiness);
                print_r($recImportedBusiness);
                print_r($error);
                exit;
            }

            // /////////////////////////////////////////////////////////////////
            // Log the row putput
            // /////////////////////////////////////////////////////////////////
            $rowLogEntry = Yii::app()->db->createCommand()->insert('batch_log',
                                array('tag'     => 'manta_import',
                                      'message' => $rowOutput
                           ));


        }

        $qryEnableKeyChecks = Yii::app()->db->createCommand("SET foreign_key_checks = 1;")->execute();


        echo "\n\nFinished.\nLoaded $recordsProcessed records.\nSucessful loads : $recordsSuccessfull\n";
        Yii::app()->end();

    }


    /**
     * Assign the category to the business.
     *
     * @param string $businessId The category id
     * @param string $categoryId The category id
     *
     * @return array validation rules for model attributes.
     * @access public
     */
    private function assignCategoryToBiz($businessId, $categoryId)
    {

        if ($categoryId)
        {
            $qryBusinessCategory = Yii::app()->db
                                             ->createCommand()
                                             ->insert('tbl_business_category',
                                                   array('business_id'     => $businessId,
                                                          'category_id'     => $categoryId
                                   ));
        }

    }

    /**
     * Add the category record if it does not exist.
     * if a parent has been given, add the parent as well.
     *
     * @param string $bizCategory The category name
     * @param string $bizparentCategoryId The parent category id
     *
     * @return array validation rules for model attributes.
     *
     * @access public
     */
    private function addCategory($categoryName = null, $parentCategoryId = null)
    {

        if (empty($categoryName)) {
            return null;
        }

        $recCategory = Yii::app()->db->createCommand()
                                 ->select('category_id')
                                 ->from('tbl_category')
                                 ->where('category_name=:category_name', array(':category_name'=>trim($categoryName)))
                                 ->limit('1')
                                 ->queryRow();

         if ($recCategory === false)
         {

             $qryNewCategory = Yii::app()->db
                                         ->createCommand()
                                         ->insert('tbl_category',
                                                 array('category_name'          => trim($categoryName),
                                                       'category_description'   => trim($categoryName),
                                                       'parent_id'              => $parentCategoryId
                                                 ));


             $insertId = Yii::app()->db
                                   ->createCommand()
                                   ->select('MAX(category_id) as category_id')
                                   ->from('tbl_category')
                                   ->queryScalar();

             if ($insertId === false)
             {
                 $insertId = null;
             }

             return $insertId;
         }
         else
         {
             return $recCategory['category_id'];
         }

    }


}

?>