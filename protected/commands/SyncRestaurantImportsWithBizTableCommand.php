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
            echo 'Processing inport rec #'.$recordsProcessed.' : '.$recImportedBusiness->NAME;

            $recBusiness = Business::model()->findByAttributes(
                                array('business_name' => $recImportedBusiness->NAME
                           ));

            // Do not process an existing business record
            if ($recBusiness != null)
            {
                echo ' ... Record already exists. Ignoring'."\n";
                continue;
            }
            echo ' ... Adding new business record'."\n";

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


            // /////////////////////////////////////////////////////////////////
            // The KEYWORDS field from the imported record is futher broken down
            // ...into other fields.
            // ...TODO: Please verify from Vendor the format of the data.
            // ...We ASSUME that the first 2 fields are the address. We use this
            // ...data because the address is not listed elsewhere in the data.
            // /////////////////////////////////////////////////////////////////
            $additionData       = explode(",", $recImportedBusiness->KEYWORDS);
            $gpsCoOrdinates     = explode(",", $recImportedBusiness->PROMOTIONALTEXT);

            // The categories are provided as
            // ...Gift Certificates > Restaurants > [Category]
            $categoryData       = explode(">", $recImportedBusiness->THIRDPARTYCATEGORY);
            $bizCategory        = $categoryData[2];



            $recCity   = City::model()->findByAttributes(array('city_name' => $recImportedBusiness->MANUFACTURER));
            if ($recCity === null)
            {
                $cityId = null;
                echo "\t".'*** WARNING: No match for city name '.$recImportedBusiness->MANUFACTURER.'. Setting city name to NULL ***'."\n";

            }
            else
            {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity->city_id;
            }

            $recBusiness->business_name                     = trim($recImportedBusiness->NAME);
            $recBusiness->business_address1                 = trim($additionData[0]);
            $recBusiness->business_address2                 = trim($additionData[1]);
            $recBusiness->business_city_id                  = $cityId;
            $recBusiness->business_zipcode                  = (int) $recImportedBusiness->MANUFACTURERID;
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
            $recBusiness->latitude                          = trim($gpsCoOrdinates[0]);
            $recBusiness->longitude                         = trim($gpsCoOrdinates[1]);
            $recBusiness->import_reference                 = $recImportedBusiness->record_id;
            $recBusiness->import_source                    = 'restaurant.com';


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
                    // Add the business categories. Parent category is fixed
                    // ...to 'Restaurant'
                    // /////////////////////////////////////////////////////////
                    $this->assignCategory($recBusiness->business_id, $bizCategory, 'Restaurant');

                    // /////////////////////////////////////////////////////////
                    // Assign the activity to the business. All restuarants will
                    // ...have an activity of 'eat'. The category will be
                    // ...the activity type.
                    // /////////////////////////////////////////////////////////
                    $this->assignActivity($recBusiness->business_id, 'Eat', $bizCategory);

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
     * @param $businessId int Business table PK
     * @param $bizCategory string Business category to assign
     * @param $parentCategory string Business parent category category
     *
     * @return int categoryId assigned
     * @access private
     */
    private function assignCategory($businessId, $bizCategory, $parentCategory = null)
    {

        // Get, or add the parent category
        if ($parentCategory != null)
        {
            $parentCategoryId = $this->getCategory($parentCategory, null);
        }
        else
        {
            $parentCategoryId = null;
        }


        // Now, get or add the business category
        $categoryId = $this->getCategory($bizCategory, $parentCategoryId);

        if ($categoryId)
        {
            // Assign the category to the business
            $modelBusinessCategory  = new BusinessCategory;
            $modelBusinessCategory->business_id     = $businessId;
            $modelBusinessCategory->category_id     = $categoryId;

            if ($modelBusinessCategory->save() === false)
            {
                echo 'Error saving business category record #'.($recordsProcessed)."\n";
                print_r($modelBusinessCategory->getErrors());
                print_r($modelBusinessCategory->attributes);
                return null;
            }
        }

        return $categoryId;

    }

    /**
     * Get the category record. Add the category if it does not exist.
     *
     * @param $bizCategory string The Business category to search (and add if not exist)
     * @param $parentCategoryId int Business parent category id to use
     *
     * @return int categoryId The PK of the located (or newly added) Category;
     * @access private
     */
    private function getCategory($bizCategory, $parentCategoryId = null)
    {

        if (empty($bizCategory))
        {
            return null;
        }

        // Search for the category, and add it if not exist.



        // Fetch the category $bizCategory
        $categoryModel = Category::model()->findByAttributes(array('category_name' => $bizCategory));

        // If the category does not exist, add it
        if ($categoryModel === null)
        {

            echo "Adding new category $bizCategory\n";

            // Add the main category
            $categoryModel                          = new Category;
            $categoryModel->category_name           = trim($bizCategory);
            $categoryModel->category_description    = 'Restaurant > '. trim($bizCategory);
            $categoryModel->parent_id               = $parentCategoryId;

            $categoryModel->save();
            if ($categoryModel->save() === false)
            {
                echo 'Error saving category record'."\n";
                print_r($categoryModel->getErrors());
                print_r($categoryModel->attributes);
                return null;
            }

        }

        $categoryId                                 = $categoryModel->category_id;
        return $categoryId;


    }

    /**
     * Assign the activity to the business.
     *
     * @param $businessId int Business table PK
     * @param $bizActivity string Business activity to assign
     * @param $bizActivityType string Business activity type to assign
     *
     * @return int bizActvityId assigned
     * @access private
     */
    private function assignActivity($businessId, $bizActivity = 'eat', $bizActivityType = null)
    {

        // Do not proceed with the activity type is not provided
        if ($bizActivityType === null)
        {
            return null;
        }
        if (empty($bizActivityType))
        {
            return null;
        }

        // Read the activity if it exists, otherwise create it
        $activityId = $this->getActivity($bizActivity, null);


        // Now, get or add the activity type
        $activityTypeId = $this->getActivityType($bizActivityType, $activityId);

        if ($activityTypeId)
        {
            // Assign the activity to the business
            $modelBusinessActivity  = new BusinessActivity();
            $modelBusinessActivity->business_id         = $businessId;
            $modelBusinessActivity->activity_id         = $activityId;
            $modelBusinessActivity->activity_type_id    = $activityTypeId;

            if ($modelBusinessActivity->save() === false)
            {
                echo 'Error saving business activity record #'.($recordsProcessed)."\n";
                print_r($modelBusinessActivity->getErrors());
                print_r($modelBusinessActivity->attributes);
                return null;
            }
        }

        return $activityId;

    }

    /**
     * Get the activity record. Add the activity if it does not exist.
     *
     * @param $bizActivity string Business activity to assign
     *
     * @return int activityId The PK of the located (or newly added) Activity;
     * @access private
     */
    private function getActivity($bizActivity = null)
    {

        if (empty($bizActivity))
        {
            return null;
        }

        // Search for the activity, and add it if not exist.


        // Fetch the activity $bizActivity
        $activityModel = Activity::model()->findByAttributes(array('keyword' => trim($bizActivity)));

        // If the category does not exist, add it
        if ($activityModel === null)
        {

            echo "Adding new activity $bizActivity\n";

            // Add the main category
            $activityModel                          = new Activity;
            $activityModel->keyword                 = trim($bizActivity);
            $activityModel->language                = 'en';
            $activityModel->related_words           = null;
            $activityModel->event_categories        = null;

            $activityModel->save();
            if ($activityModel->save() === false)
            {
                echo 'Error saving activity record'."\n";
                print_r($activityModel->getErrors());
                print_r($activityModel->attributes);
                return null;
            }

        }

        $actvityId                                 = $activityModel->activity_id;
        return $actvityId;

    }

    /**
     * Get the activity type record. Add the activitytype if it does not exist.
     *
     * @param $bizActivityType string Business activity to assign
     * @param $bizActivityId int activityId to assign
     *
     * @return int activityTypeId The PK of the located (or newly added) ActivityType;
     * @access private
     */
    private function getActivityType($bizActivityType = null, $bizActivityId = null)
    {

        if (empty($bizActivityType))
        {
            return null;
        }

        // Search for the activitytype, and add it if not exist.


        // Fetch the activity $bizActivityType
        $activityTypeModel = ActivityType::model()->findByAttributes(array('keyword' => trim($bizActivityType)));

        // If the category does not exist, add it
        if ($activityTypeModel === null)
        {

            echo "Adding new activity $bizActivityType\n";

            // Add the main category
            $activityTypeModel                          = new ActivityType;
            $activityTypeModel->keyword                 = trim($bizActivityType);
            $activityTypeModel->language                = 'en';
            $activityTypeModel->related_words           = null;
            $activityTypeModel->activity_id             = $bizActivityId;

            $activityTypeModel->save();
            if ($activityTypeModel->save() === false)
            {
            echo 'Error saving category record'."\n";
                print_r($activityTypeModel->getErrors());
                print_r($activityTypeModel->attributes);
                return null;
            }

            }

            $actvityTypeId                              = $activityTypeModel->activity_type_id;
            return $actvityTypeId;

    }

}

?>