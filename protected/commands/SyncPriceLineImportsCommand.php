<?php

/**
 * Command Class for the shell command SyncPriceLineImports to copy imported
 * ...priceline records into our local list
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncPriceLineImportsCommand is a Yii Console command that copies imported
 * ...Priceline hotel records into our local list for offline usage.
 * ...
 * ...Imported TN events records are read from a seperate console command
 * ...process to read from a supplied database file and imported into
 * ...various table.
 * ...
 *
 * @package Commands
 * @version 1.0
 */


class SyncPriceLineImportsCommand extends CConsoleCommand
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

        $recordsProcessed       = 0;
        $recordsSuccessfull     = 0;

        // /////////////////////////////////////////////////////////////////////
        // Read all Hotel information in Florida
        // /////////////////////////////////////////////////////////////////////


        $listHotels = Yii::app()->db->createCommand()
                        ->select('hotel.*, city.city as city_name')
                        ->from('florida.affiliate_data_ABT-hotel_v3 hotel')
                        ->leftJoin('florida.affiliate_data_ABT-city_v3 city', 'hotel.cityid_ppn = city.cityid_ppn')
                        ->leftJoin('florida.affiliate_data_state_v3 state',   'city.state_code  = state.state_code_ppn')
                        ->where('state.state_code_ppn = :state_code_ppn AND state.country_code_ppn = :country_code_ppn',
                                 array(':state_code_ppn'=>'FL', ':country_code_ppn'=>'US'))
                        ->QueryAll();

        foreach ($listHotels as $itemHotel)
        {

            $recordsProcessed++;


            echo 'Processing hotel record #'.$recordsProcessed.' : '.$itemHotel['hotel_name'].' ('.$itemHotel['hotelid_ppn'].').';

            // /////////////////////////////////////////////////////////////////
            // Look for an existing entry in the business listing. We ignore any
            // ...entries that are alread recorded.
            // /////////////////////////////////////////////////////////////////
            $itemBusiness = Business::model()->findByAttributes(array('import_source'=>'priceline',
                                                                      'import_reference'=>$itemHotel['hotelid_ppn'])
                                                               );

            // Do not process an existing business record
            if ($itemBusiness != null) {
                echo ' Record already exists with ID '.$itemBusiness->business_id.'. Ignoring.'."\n";
                continue;
            }

            echo ' ... Adding new business record' . "\n";

            // /////////////////////////////////////////////////////////////////
            // The record has not been processed. Create a new record and save.
            // /////////////////////////////////////////////////////////////////
            $itemBusiness = new Business();

            // /////////////////////////////////////////////////////////////////
            // Find the city record where the city is located. Do this my
            // ...mapping the Priceline city name by our own city name (which
            // ...might be different).
            // /////////////////////////////////////////////////////////////////
            $recCity = City::model()->findByAttributes(array(
                'city_name' => $itemHotel['city_name']
            ));
            if ($recCity === null) {
                $cityId = null;
                echo "\t" . '*** WARNING: No match for city name ' . $itemHotel['city_name'] . '. Setting city name to NULL ***' . "\n";
            } else {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity->city_id;
            }

            $itemBusiness->business_name             = trim($itemHotel['hotel_name']);
            $itemBusiness->business_address1         = trim($itemHotel['hotel_address']);
            $itemBusiness->business_address2         = '';
            $itemBusiness->business_city_id          = $cityId;
            $itemBusiness->business_zipcode          = (int) $itemHotel['postal_code'];
            $itemBusiness->business_phone_ext        = null;
            $itemBusiness->business_phone            = null;
            $itemBusiness->business_email            = null;
            $itemBusiness->business_website          = null;
            $itemBusiness->business_description      = $itemHotel['property_description'];
            $itemBusiness->image                     = $itemHotel['thumbnail'];
            $itemBusiness->business_keywords         = null;
            $itemBusiness->claim_status              = 'Unclaimed';
            $itemBusiness->claim_processing_time     = null;
            $itemBusiness->claimed_by                = null;
            $itemBusiness->claim_rejection_reason    = null;
            $itemBusiness->is_active                 = 'Y';
            $itemBusiness->is_featured               = 'N';
            $itemBusiness->is_closed                 = 'N';
            $itemBusiness->latitude                  = trim($itemHotel['latitude']);
            $itemBusiness->longitude                 = trim($itemHotel['longitude']);
            $itemBusiness->business_type             = 'hotel';
            $itemBusiness->star_rating               = trim($itemHotel['star_rating']);
            $itemBusiness->low_rate                  = trim($itemHotel['low_rate']);
            $itemBusiness->room_count                = trim($itemHotel['room_count']);
            $itemBusiness->opening_time              = trim($itemHotel['check_in']);
            $itemBusiness->closing_time              = trim($itemHotel['check_out']);
            $itemBusiness->import_reference          = $itemHotel['hotelid_ppn'];
            $itemBusiness->import_source             = 'priceline';


            // NOTE: The following fields from the business tables are not set
            // NOTE: ...explicitly and remain unset or use default values.
            // $itemBusiness->business_allow_review = '';
            // $itemBusiness->business_allow_rating = '';
            // $itemBusiness->add_request_processing_status = 0;
            // $itemBusiness->add_request_processing_time = 0;
            // $itemBusiness->add_request_processed_by = 0;
            // $itemBusiness->add_request_rejection_reason = null;
            // $itemBusiness->activation_status = null;

            try {

                if ($itemBusiness->save()) {

                    $recordsSuccessfull ++;

                    // /////////////////////////////////////////////////////////
                    // Assign the activity to the business. All hotels will
                    // ...have an activity of 'stay'.
                    // /////////////////////////////////////////////////////////
                    $this->assignActivity($itemBusiness->business_id, 'Stay');




                } else {
                    echo 'Error saving record #' . ($recordsProcessed) . "\n";
                    print_r($itemBusiness->getErrors());
                    print_r($itemBusiness->attributes);
                    Yii::app()->end();
                }
            } catch (Exception $error) {
                print_r($itemBusiness);
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
     * @param $businessId int
     *            Business table PK
     * @param $bizCategory string
     *            Business category to assign
     * @param $parentCategory string
     *            Business parent category category
     *
     * @return int categoryId assigned
     * @access private
     */
    private function assignCategory($businessId, $bizCategory, $parentCategory = null)
    {

        // Get, or add the parent category
        if ($parentCategory != null) {
            $parentCategoryId = $this->getCategory($parentCategory, null);
        } else {
            $parentCategoryId = null;
        }

        // Now, get or add the business category
        $categoryId = $this->getCategory($bizCategory, $parentCategoryId);

        if ($categoryId) {
            // Assign the category to the business
            $modelBusinessCategory = new BusinessCategory();
            $modelBusinessCategory->business_id = $businessId;
            $modelBusinessCategory->category_id = $categoryId;

            if ($modelBusinessCategory->save() === false) {
                echo 'Error saving business category record #' . ($recordsProcessed) . "\n";
                print_r($modelBusinessCategory->getErrors());
                print_r($modelBusinessCategory->attributes);
                return null;
            }
        }

        return $categoryId;
    }

    /**
     * Get the category record.
     * Add the category if it does not exist.
     *
     * @param $bizCategory string
     *            The Business category to search (and add if not exist)
     * @param $parentCategoryId int
     *            Business parent category id to use
     *
     * @return int categoryId The PK of the located (or newly added) Category;
     * @access private
     */
    private function getCategory($bizCategory, $parentCategoryId = null)
    {
        if (empty($bizCategory)) {
            return null;
        }

        // Search for the category, and add it if not exist.

        // Fetch the category $bizCategory
        $categoryModel = Category::model()->findByAttributes(array(
            'category_name' => $bizCategory
        ));

        // If the category does not exist, add it
        if ($categoryModel === null) {

            echo "Adding new category $bizCategory\n";

            // Add the main category
            $categoryModel = new Category();
            $categoryModel->category_name = trim($bizCategory);
            $categoryModel->category_description = 'Restaurant > ' . trim($bizCategory);
            $categoryModel->parent_id = $parentCategoryId;

            $categoryModel->save();
            if ($categoryModel->save() === false) {
                echo 'Error saving category record' . "\n";
                print_r($categoryModel->getErrors());
                print_r($categoryModel->attributes);
                return null;
            }
        }

        $categoryId = $categoryModel->category_id;
        return $categoryId;
    }

    /**
     * Assign the activity to the business.
     *
     * @param $businessId int
     *            Business table PK
     * @param $bizActivity string
     *            Business activity to assign
     * @param $bizActivityType string
     *            Business activity type to assign
     *
     * @return int bizActvityId assigned
     * @access private
     */
    private function assignActivity($businessId, $bizActivity = 'eat', $bizActivityType = null)
    {

        // Do not proceed with the activity type is not provided
        if ($bizActivityType === null) {
            return null;
        }
        if (empty($bizActivityType)) {
            return null;
        }

        // Read the activity if it exists, otherwise create it
        $activityId = $this->getActivity($bizActivity, null);

        // Now, get or add the activity type
        $activityTypeId = $this->getActivityType($bizActivityType, $activityId);

        if ($activityTypeId) {
            // Assign the activity to the business
            $modelBusinessActivity = new BusinessActivity();
            $modelBusinessActivity->business_id = $businessId;
            $modelBusinessActivity->activity_id = $activityId;
            $modelBusinessActivity->activity_type_id = $activityTypeId;

            if ($modelBusinessActivity->save() === false) {
                echo 'Error saving business activity record #' . ($recordsProcessed) . "\n";
                print_r($modelBusinessActivity->getErrors());
                print_r($modelBusinessActivity->attributes);
                return null;
            }
        }

        return $activityId;
    }

    /**
     * Get the activity record.
     * Add the activity if it does not exist.
     *
     * @param $bizActivity string
     *            Business activity to assign
     *
     * @return int activityId The PK of the located (or newly added) Activity;
     * @access private
     */
    private function getActivity($bizActivity = null)
    {
        if (empty($bizActivity)) {
            return null;
        }

        // Search for the activity, and add it if not exist.

        // Fetch the activity $bizActivity
        $activityModel = Activity::model()->findByAttributes(array(
            'keyword' => trim($bizActivity)
        ));

        // If the category does not exist, add it
        if ($activityModel === null) {

            echo "Adding new activity $bizActivity\n";

            // Add the main category
            $activityModel = new Activity();
            $activityModel->keyword = trim($bizActivity);
            $activityModel->language = 'en';
            $activityModel->related_words = null;
            $activityModel->event_categories = null;

            $activityModel->save();
            if ($activityModel->save() === false) {
                echo 'Error saving activity record' . "\n";
                print_r($activityModel->getErrors());
                print_r($activityModel->attributes);
                return null;
            }
        }

        $actvityId = $activityModel->activity_id;
        return $actvityId;
    }

    /**
     * Get the activity type record.
     * Add the activitytype if it does not exist.
     *
     * @param $bizActivityType string
     *            Business activity to assign
     * @param $bizActivityId int
     *            activityId to assign
     *
     * @return int activityTypeId The PK of the located (or newly added) ActivityType;
     * @access private
     */
    private function getActivityType($bizActivityType = null, $bizActivityId = null)
    {
        if (empty($bizActivityType)) {
            return null;
        }

        // Search for the activitytype, and add it if not exist.

        // Fetch the activity $bizActivityType
        $activityTypeModel = ActivityType::model()->findByAttributes(array(
            'keyword' => trim($bizActivityType)
        ));

        // If the category does not exist, add it
        if ($activityTypeModel === null) {

            echo "Adding new activity $bizActivityType\n";

            // Add the main category
            $activityTypeModel = new ActivityType();
            $activityTypeModel->keyword = trim($bizActivityType);
            $activityTypeModel->language = 'en';
            $activityTypeModel->related_words = null;
            $activityTypeModel->activity_id = $bizActivityId;

            $activityTypeModel->save();
            if ($activityTypeModel->save() === false) {
                echo 'Error saving category record' . "\n";
                print_r($activityTypeModel->getErrors());
                print_r($activityTypeModel->attributes);
                return null;
            }
        }

        $actvityTypeId = $activityTypeModel->activity_type_id;
        return $actvityTypeId;
    }

}

?>