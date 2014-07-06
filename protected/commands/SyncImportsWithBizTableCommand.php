<?php

/**
 * Command Class for the shell command SyncImportsWithBizTable to copy imported
 * ...business records into the list of usable business records.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncImportsWithBizTable is a Yii Console command that copies imported
 * ...business records into the list of usable business records.
 * ...
 * ...Imported business records are read from a seperate console command
 * ...process to read from a supplied database file and imported into the
 * ...<i>imported_business</i> table.
 * ...
 * ...The SyncImportsWithBizTable command will read the imported_business table
 * ...and copy data to the sites business table.
 * ...Validation is done to ensure :-
 * ...   - only records of specific categories are copied
 * ...   - already excluded entries are not re-copied
 * ...   - the imported_business table is updated to reflect the synced records
 *
 * @package Commands
 * @version 1.0
 */


class SyncImportsWithBizTableCommand extends CConsoleCommand
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
        usleep(10000);

        ini_set('memory_limit', '-1');

        // /////////////////////////////////////////////////////////////////////
        // Read all ImportedBusiness records
        // /////////////////////////////////////////////////////////////////////
        $listImportedBusiness   = ImportedBusiness::model()->findAll(array('limit' => 100000));
        //$listImportedBusiness   = ImportedBusiness::model()->findAll();

        $recordsProcessed       = 0;
        $recordsSuccessfull     = 0;

        echo "\n";

        foreach ($listImportedBusiness as $recImportedBusiness)
        {

            $recordsProcessed++;

            echo 'Processing import record for ' . $recImportedBusiness->company_name;

            // ////////////////////////////////////////////////////////////////
            // Check if the business exists by checking the biz namea
            // ...and location? and ??  // TODO: Check with Client
            // ////////////////////////////////////////////////////////////////
            $recBusiness = Business::model()->findByAttributes(
                                array('business_name' => $recImportedBusiness->company_name
                           ));

            // Do not process an existing business record
            if ($recBusiness != null)
            {
                echo ' ** Record already exists at position ' . $recBusiness->business_id;
                echo ' ** Ingoring.' . "\n";
                continue;
            }

            // ////////////////////////////////////////////////////////////////
            // If we are here, then we have a new record to be added.
            // ////////////////////////////////////////////////////////////////

            // ////////////////////////////////////////////////////////////////
            // Map the fields of the imported record to the business table
            // ////////////////////////////////////////////////////////////////
            $recBusiness = new Business;

            $recCity   = City::model()->findByAttributes(array('city_name' => $recImportedBusiness->city));
            if ($recCity === null)
            {
                echo ' (** No city record for imported city ' . $recImportedBusiness->city . ' **)';
                $cityId = null;
            }
            else
            {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity->city_id;
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
            $recBusiness->image                             = null;
            $recBusiness->business_keywords                 = '';
            $recBusiness->claim_status                      = 'Unclaimed';
            $recBusiness->claim_processing_time             = null;
            $recBusiness->claimed_by                        = null;
            $recBusiness->claim_rejection_reason            = null;
            $recBusiness->is_active                         = 'Y';
            $recBusiness->is_featured                       = 'N';
            $recBusiness->is_closed                         = 'N';
            $recBusiness->latitude                          = $recImportedBusiness->latitude;
            $recBusiness->longitude                         = $recImportedBusiness->longitude;


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
            // `ID1` int(11) DEFAULT NULL,
            // `ID` int(11) DEFAULT NULL,
            // `manta_industry` tinytext,
            // `old_db_sic` tinytext,
            // `old_db_category` tinytext,
            // `gogo_source_url` tinytext,
            // `manta_source_url` tinytext,
            // `TableID` int(11) DEFAULT NULL,
            // `TP` tinytext,
            // `zip5` tinytext


            try
            {

                if ($recBusiness->save())
                {

                    echo " ** Record saved. **\n";

                    $recordsSuccessfull++;

                    // /////////////////////////////////////////////////////////
                    // Add the business categories
                    // /////////////////////////////////////////////////////////
                    $this->assignCategory($recBusiness->business_id, $recImportedBusiness->manta_category, $recImportedBusiness->manta_subcategory);
                    $this->assignCategory($recBusiness->business_id, $recImportedBusiness->gogo_category, $recImportedBusiness->gogo_subcategory);

                }
                else
                {
                    echo 'Error saving record #'.($recordsProcessed)."\n";
                    print_r($recBusiness->getErrors());
                    print_r($recBusiness->attributes);
                }


            } catch (Exception $error)
            {
                print_r($recBusiness);
                print_r($error);
            }

        }


        echo "\n\nFinished.\nLoaded $recordsProcessed records.\nSucessful loads : $recordsSuccessfull\n";
        Yii::app()->end();

    }


    /**
     * Assign the category to the business.
     *
     * @param <none> <none>
     *
     * @return array validation rules for model attributes.
     * @access public
     */
    private function assignCategory($businessId, $bizCategory, $bizSubCategory)
    {

        $categoryId = $this->getCategory($bizCategory, $bizSubCategory);

        if ($categoryId)
        {
            $modelBusinessCategory  = new BusinessCategory;
            $modelBusinessCategory->business_id     = $businessId;
            $modelBusinessCategory->category_id     = $categoryId;

            if ($modelBusinessCategory->save() === false)
            {
                echo 'Error saving record #'.($recordsProcessed)."\n";
                print_r($recBusiness->getErrors());
                print_r($recBusiness->attributes);
            }
        }


    }

    /**
     * Get the category record. Add the category if it does not exist.
     *
     * @param <none> <none>
     *
     * @return array validation rules for model attributes.
     * @access public
     */
    private function getCategory($bizCategory, $bizSubCategory)
    {

        if (empty($bizCategory))
        {
            return null;
        }

        // Fetch the category$bizCategory
        $categoryModel = Category::model()->findByAttributes(array('category_name' => trim($bizCategory)));

        // If the category does not exist, add it
        if ($categoryModel === null)
        {

            echo "Add new category $bizCategory\n";

            // Add the main category
            $categoryModel                          = new Category;
            $categoryModel->category_name           = $bizCategory;
            $categoryModel->category_description    = $bizCategory;

            $categoryModel->save();
            if ($categoryModel->save() === false)
            {
                echo 'Error saving category record'."\n";
                print_r($categoryModel->getErrors());
                print_r($categoryModel->attributes);
            }
            $categoryId                             = $categoryModel->category_id;


            if (!empty($bizSubCategory))
            {
                // Add the sub-category
                echo "Add new subcategory $bizSubCategory\n";

                $subcategoryModel                          = new Category;
                $subcategoryModel->category_name           = $bizSubCategory;
                $subcategoryModel->category_description    = $bizSubCategory;
                $subcategoryModel->parent_id               = $categoryId;

                $subcategoryModel->save();
                if ($subcategoryModel->save() === false)
                {
                    echo 'Error saving category record'."\n";
                    print_r($subcategoryModel->getErrors());
                    print_r($subcategoryModel->attributes);
                }
            }

        }

        return $categoryModel->category_id;

    }

}

?>