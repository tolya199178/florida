<?php

/**
 * Command Class for the shell command SyncRestaurantImportsWithBizTable to copy
 * ...imported business records into the list of usable business records.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncRestaurantImportsWithBizTable is a Yii Console script that copies imported
 * ...business records into the list of usable business records.
 * ...
 * ...Imported business records are read from a seperate console command
 * ...process to read from a supplied database file and imported into the
 * ...<i>restaurant_import</i> table.
 * ...
 * ...The SyncRestaurantImportsWithBizTable command script will read the
 * ...restaurant_import table and copy data to the sites business table.
 * ...Validation is done to ensure :-
 * ...   - already excluded entries are not re-copied
 * ...   - the restaurant_import table is updated to reflect the synced records
 *
 * @package Commands
 * @version 1.0
 */


class SyncRestaurantImportsWithBizTableCommand extends CConsoleCommand
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
        // Read all ImportedBusiness records that have not been processed.
        // ...For now, we select only biz in Florida
        // /////////////////////////////////////////////////////////////////////
        $listImportedBusiness   = RestaurantImport::model()->findAll('sync_business_id IS NULL AND PUBLISHER="FL"');

        $recordsProcessed       = 0;
        $recordsSuccessfull     = 0;

        foreach ($listImportedBusiness as $recImportedBusiness)
        {

            $recordsProcessed++;

            // ////////////////////////////////////////////////////////////////
            // Check if the business exists by checking the biz name
            // ...and location? and ??  // TODO: Check with Client
            // ////////////////////////////////////////////////////////////////
            $recBusiness = Business::model()->findByAttributes(
                                array('business_name' => $recImportedBusiness->NAME
                           ));

            // Do not process an existing business record
            if ($recBusiness != null)
            {
                continue;
            }

            // ////////////////////////////////////////////////////////////////
            // If we are here, then we have a new record to be added.
            // ////////////////////////////////////////////////////////////////

            // ////////////////////////////////////////////////////////////////
            // Map the fields of the imported record to the business table.
            //
            // ...Some of the fields are mapped as follows :-
            // ...   [MANUFACTURER]         => City
            // ...   [MANUFACTURERID]       => Postal Code
            // ...   [PUBLISHER]            => State Abbreviation
            // ...   [PROMOTIONALTEXT]      => GPS coordinates
            //
            // ////////////////////////////////////////////////////////////////
            $recBusiness = new Business;

//             print_r($recImportedBusiness->attributes);
//             continue;

            // /////////////////////////////////////////////////////////////////
            // The KEYWORDS field from the imported record is futher broken down
            // ...into other fields.
            // ...TODO: Please verify from Vendor the format of the data.
            // ...We ASSUME that the first 2 fields are the address. We use this
            // ...data because the address is not listed elsewhere in the data.
            // /////////////////////////////////////////////////////////////////
            $additionData       = explode(",", $recImportedBusiness->KEYWORDS);
            $gpsCoOrdinates     = explode(",", $recImportedBusiness->PROMOTIONALTEXT);



            $recCity   = City::model()->findByAttributes(array('city_name' => $recImportedBusiness->MANUFACTURER));
            if ($recCity === null)
            {
                $cityId = null;
            }
            else
            {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity->city_id;
            }

            $recBusiness->business_name                     = $recImportedBusiness->NAME;
            $recBusiness->business_address1                 = $additionData[0];
            $recBusiness->business_address2                 = $additionData[0];
            $recBusiness->business_city_id                  = $cityId;
            $recBusiness->business_zipcode                  = $recImportedBusiness->MANUFACTURERID;
            $recBusiness->business_phone_ext                = null;
            $recBusiness->business_phone                    = null;
            $recBusiness->business_email                    = null;
            $recBusiness->business_website                  = null;
            $recBusiness->business_description              = $recImportedBusiness->DESCRIPTION;
            $recBusiness->image                             = $recImportedBusiness->IMAGEURL;
            $recBusiness->business_keywords                 = implode(",", array_slice($additionData,3));
            $recBusiness->claim_status                      = 'Unclaimed';
            $recBusiness->claim_processing_time             = null;
            $recBusiness->claimed_by                        = null;
            $recBusiness->claim_rejection_reason            = null;
            $recBusiness->is_active                         = 'Y';
            $recBusiness->is_featured                       = 'N';
            $recBusiness->is_closed                         = 'N';
            $recBusiness->latitude                          = $gpsCoOrdinates[0];
            $recBusiness->longitude                         = $gpsCoOrdinates[1];


            // NOTE: The following fields from the business tables are not set
            // NOTE: ...explicitly and remain unset or use default values.
            // $recBusiness->business_allow_review             = '';
            // $recBusiness->business_allow_rating             = '';
            // $recBusiness->add_request_processing_status     = 0;
            // $recBusiness->add_request_processing_time       = 0;
            // $recBusiness->add_request_processed_by          = 0;
            // $recBusiness->add_request_rejection_reason      = null;
            // $recBusiness->activation_status                 = null;


            try {

                if ($recBusiness->save())
                {

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
                    Yii::app()->end();
                }


            } catch (Exception $error) {
                print_r($recBusiness);
                print_r($error);
                Yii::app()->end();
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
        $categoryModel = Category::model()->findByAttributes(array('category_name' => $bizCategory));

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

                $categoryModel                          = new Category;
                $categoryModel->category_name           = $bizSubCategory;
                $categoryModel->category_description    = $bizSubCategory;
                $categoryModel->parent_id               = $categoryId;

                $categoryModel->save();
                if ($categoryModel->save() === false)
                {
                    echo 'Error saving category record'."\n";
                    print_r($categoryModel->getErrors());
                    print_r($categoryModel->attributes);
                }
            }




        }

    }

}

?>