<?php

/**
 * Command Class for the shell command SyncGetARoomImport to copy imported
 * ...GetYourGuide records into our local list
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * SyncGetARoomImport is a Yii Console command that copies imported
 * ...Get-a-room hotel records into our local list for offline usage.
 * ...
 * ...Imported get-a-room records are read from a separate console command
 * ...process to read from the get-a-room web service file and import into
 * ...the <i>getaroom_import</i> table.
 * ...
 * ...The SyncGetARoomImport command will read the getaroom_import table
 * ...and copy data to the business and tbl_getyourguide_product tables.
 * ...Category and activity details are pre-populated.
 *
 * ...Validation is done to ensure :-
 * ... - already excluded entries are not re-copied
 *
 * @package Commands
 * @version 1.0
 */
define('SAVE_PHOTO_URL', '1');
define('SAVE_PHOTO_LOCALLY', '2');

class SyncGetARoomImportCommand extends CConsoleCommand
{

    /**
     *
     * @var string imagesDirPath Directory where Business images will be stored
     * @access private
     */
    private $imagesDirPath;

    /**
     *
     * @var string imagesDirPath Directory where Business image thumbnails will be stored
     * @access private
     */
    private $thumbnailsDirPath;

    /**
     *
     * @var string thumbnailWidth thumbnail width
     * @access private
     */
    private $thumbnailWidth = 100;

    /**
     *
     * @var string thumbnailWidth thumbnail width
     * @access private
     */
    private $thumbnailHeight = 100;

    /**
     * Command main function.
     * This function will run automatically once the CConsoleCommand environment
     * ...is initialised
     *
     * @param
     *            args array command line arguements
     *
     * @return array validation rules for model attributes.
     * @access public
     */
    public function run($args)
    {

        // Show the help screen and exit is the user requests
        if (isset($args[0]) && (($args[0] == '-h') || ($args[0] == '--help'))) {
            $this->showUsage();
            exit();
        }

        // Process the command line options
        $resolvedArgs               = $this->resolveRequest($args);
        $userOptions                = $resolvedArgs[1];

        // Set default options or override them from the command line
        $photoSaveMethod            = SAVE_PHOTO_URL;
        if (isset($userOptions['photo']) && ($userOptions['photo'] == 'image')) {
            $photoSaveMethod        = SAVE_PHOTO_LOCALLY;
        }

        $optionOverwrite            = false;
        if (isset($userOptions['overwrite']) && ($userOptions['overwrite'] == 'yes')) {
            echo '*** Running in OVERWRITE MODE ***' . "\n";
            $optionOverwrite        = true;
        }

        $systemRoot                 = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..';
        $this->imagesDirPath = $systemRoot . '/uploads/images/business';
        $this->thumbnailsDirPath    = $systemRoot . '/uploads/images/business/thumbnails';

        $recordsProcessed           = 0;
        $recordsSuccessfull         = 0;

        // /////////////////////////////////////////////////////////////////////
        // Read all Hotel information in Florida
        // /////////////////////////////////////////////////////////////////////

        $listHotels = GetaroomImport::model()->findAll();


        foreach ($listHotels as $objHotel) {

            $itemHotel = $objHotel->attributes;

            $recordsProcessed ++;

            echo 'Processing hotel record #' . $recordsProcessed . ' : ' . $itemHotel['title'] . ' (' . $itemHotel['uuid'] . ').';

            // /////////////////////////////////////////////////////////////////
            // Look for an existing entry in the business listing. We ignore any
            // ...entries that are alread recorded.
            // /////////////////////////////////////////////////////////////////
            $itemBusiness = Business::model()->findByAttributes(array(
                                                                'import_source'     => 'getaroom',
                                                                'import_reference'  => $itemHotel['uuid']
                                               ));

            // Do not process an existing business record
            if ($itemBusiness != null) {
                echo ' Record already exists with ID ' . $itemBusiness->business_id . '.';

                if ($optionOverwrite) {
                    echo 'Updating.' . "\n";
                } else {
                    echo 'Ignoring.' . "\n";
                    continue;
                }
            } else {
                echo ' ... Adding new business record' . "\n";

                // /////////////////////////////////////////////////////////////////
                // The record has not been processed. Create a new record and save.
                // /////////////////////////////////////////////////////////////////
                $itemBusiness       = new Business();
            }

            // /////////////////////////////////////////////////////////////////
            // Find the city record where the city is located. Do this my
            // ...mapping the Priceline city name by our own city name (which
            // ...might be different).
            // /////////////////////////////////////////////////////////////////
            $recCity            = City::model()->findByAttributes(array(
                                                                    'city_name' => $itemHotel['location_city']
                                                 ));

            if ($recCity === null) {
                $cityId = null;
                echo "\t" . '*** WARNING: No match for city name ' . $itemHotel['location_city'] . '. Setting city name to NULL ***' . "\n";
            } else {
                // NOTE: This will result in an exception due to a referential integrity
                // NOTE: ...check with business.business_city_id field.
                // NOTE: ...This is however, our intented behaviour.
                $cityId = $recCity->city_id;
            }

            // /////////////////////////////////////////////////////////////////
            // Extract the amenities and create them as a command delimited
            // ...list, so they can be added as business keywords.
            // /////////////////////////////////////////////////////////////////
            $keywordsList           = array();
            $listAmenities          = unserialize($itemHotel['amenity']);
            foreach ($listAmenities as $itemAmenity)
            {
                $keywordsList[]     = trim($itemAmenity['title']);
            }
            $strKeywords            = implode(",", $keywordsList);


            $itemBusiness->business_name                = trim($itemHotel['title']);
            $itemBusiness->business_address1            = trim($itemHotel['location_street']);
            $itemBusiness->business_address2            = '';
            $itemBusiness->business_city_id             = $cityId;
            $itemBusiness->business_zipcode             = (int) $itemHotel['location_zip'];
            $itemBusiness->business_phone_ext           = null;
            $itemBusiness->business_phone               = null;
            $itemBusiness->business_email               = null;
            $itemBusiness->business_website             = null;
            $itemBusiness->business_description         = $itemHotel['sanitized_description'];
            $itemBusiness->image                        = $itemHotel['thumbnail_filename'];
            $itemBusiness->business_keywords            = $strKeywords;
            $itemBusiness->claim_status                 = 'Unclaimed';
            $itemBusiness->claim_processing_time        = null;
            $itemBusiness->claimed_by                   = null;
            $itemBusiness->claim_rejection_reason       = null;
            $itemBusiness->is_active                    = 'Y';
            $itemBusiness->is_featured                  = 'N';
            $itemBusiness->is_closed                    = 'N';
            $itemBusiness->latitude                     = trim($itemHotel['lat']);
            $itemBusiness->longitude                    = trim($itemHotel['lng']);
            $itemBusiness->business_type                = 'hotel';
            $itemBusiness->star_rating                  = trim($itemHotel['review_rating']);
            $itemBusiness->low_rate                     = null;
            $itemBusiness->room_count                   = null;
            $itemBusiness->opening_time                 = null;
            $itemBusiness->closing_time                 = null;
            $itemBusiness->import_reference             = $itemHotel['uuid'];
            $itemBusiness->import_source                = 'getaroom';


            // NOTE: The following fields from the import tables are not copied

            // // Linked thorugh -> city_id -> City -> State -> Country
            // $importRecord->location_country         = '';
            // // Linked thorugh -> city_id -> City -> State
            // $importRecord->location_state           = '';
            // $importRecord->permalink                = '';
            // $importRecord->rating                   = '';
            // $importRecord->short_description        = '';
            // // Linked thorugh -> city_id -> City->[time-zone]
            // $importRecord->time_zone                = '';
            // $importRecord->market                   = '';

            // NOTE: The following fields from the business table are not set
            // NOTE: ...explicitly and remain unset or use default values.

            // $itemBusiness->business_allow_review = '';
            // $itemBusiness->business_allow_rating = '';
            // $itemBusiness->add_request_processing_status = 0;
            // $itemBusiness->add_request_processing_time = 0;
            // $itemBusiness->add_request_processed_by = 0;
            // $itemBusiness->add_request_rejection_reason = null;
            // $itemBusiness->activation_status = null;

            try {

                // /////////////////////////////////////////////////////////////
                // Write, or overwrite the record if overwrite mode
                // /////////////////////////////////////////////////////////////
                if (($itemBusiness->isNewRecord) || ((! $itemBusiness->isNewRecord) && ($optionOverwrite))) {

                    if ($itemBusiness->save()) {

                        $recordsSuccessfull ++;

                        // /////////////////////////////////////////////////////////
                        // Assign the activity to the business. All hotels will
                        // ...have an activity of 'stay'.
                        // /////////////////////////////////////////////////////////
                        $this->assignActivity($itemBusiness->business_id, 'Stay');

                        // /////////////////////////////////////////////////////////
                        // Assign the activity to the business. All hotels will
                        // ...have an activity of 'stay'.
                        // /////////////////////////////////////////////////////////
                        $this->assignCategory($itemBusiness->business_id, 'Hotel', null);

                        // /////////////////////////////////////////////////////////
                        // Save image locally, if option is set
                        // /////////////////////////////////////////////////////////
                        if ($photoSaveMethod == SAVE_PHOTO_LOCALLY) {

                            $imageFileName = $this->saveImageFromURL($itemBusiness->image, $itemBusiness->business_id);

                            $this->createThumbnail($imageFileName);

                            // Save the business record (agaim)
                            $itemBusiness->image = $imageFileName;
                            $itemBusiness->save();
                        }


                    } else {
                        echo 'Error saving record #' . ($recordsProcessed) . "\n";
                        print_r($itemBusiness->getErrors());
                        print_r($itemBusiness->attributes);
                        Yii::app()->end();
                    }
                } else {
                    echo 'Record #' . ($recordsProcessed) . ' not saved (safe mode).' . "\n";
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

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com Priceline Import Utility (cli) (Version : 1.00)
Usage: yiic SyncPriceLineImports [options]

where :
--photo=url|image       - Option to either save remote image URL, or copy image locally. Default is {url}
--overwrite=yes|no      - Option to overwrite hotel data. Default is {no}.
\n
EOD;

        echo $usage;
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
    private function assignActivity($businessId, $bizActivity = 'stay', $bizActivityType = null)
    {

        // Do not proceed with the activity type is not provided
        if ($bizActivity === null) {
            return null;
        }
        if (empty($bizActivity)) {
            return null;
        }

        // Read the activity if it exists, otherwise create it
        $activityId = $this->getActivity($bizActivity, null);


        // Now, get or add the activity type
        $activityTypeId = $this->getActivityType($bizActivityType, $activityId);

        if ($activityId) {
            // Assign the activity to the business, if required
            $modelBusinessActivity = BusinessActivity::model()->findByAttributes(array(
                                                                    'business_id' => $businessId,
                                                                    'activity_id' => $activityId,
                                                                    'activity_type_id' => $activityTypeId)
                                                                );
            if ($modelBusinessActivity === null)
            {
                $modelBusinessActivity = new BusinessActivity;
            }

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

    /**
     * Create a thumbnail image from the filename give, Store it in the thumnails folder.
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    private function createThumbnail($imageFileName, $sizeWidth = 0, $sizeHeight = 0)
    {
        if ($sizeWidth == 0) {
            $sizeWidth = $this->thumbnailWidth;
        }
        if ($sizeHeight == 0) {
            $sizeHeight = $this->thumbnailHeight;
        }

        $thumbnailPath = $this->thumbnailsDirPath . DIRECTORY_SEPARATOR . $imageFileName;
        $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $imageFileName;

        $imgThumbnail = new Thumbnail();
        $imgThumbnail->PathImgOld = $imagePath;
        $imgThumbnail->PathImgNew = $thumbnailPath;

        $imgThumbnail->NewWidth = $sizeWidth;
        $imgThumbnail->NewHeight = $sizeHeight;

        $result = $imgThumbnail->create_thumbnail_images();

        if (! $result) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Delete images for the business.
     * Normally invoked when business is being deleted.
     *
     * @param string $imageFileName
     *            the name of the file
     *
     * @return <none> <none>
     * @access public
     */
    private function deleteImages($imageFileName)
    {
        $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $imageFileName;
        @unlink($imagePath);

        $thumbnailPath = $this->thumbnailsDirPath . DIRECTORY_SEPARATOR . $imageFileName;
        @unlink($thumbnailPath);
    }

    /**
     * Save image file locally, from URL
     *
     * @param string $mageURL
     *            the url to the image file
     *
     * @return <none> <none>
     * @access public
     */
    private function saveImageFromURL($imageURL, $businessId)
    {
        $photoFileName = basename($imageURL);

        $imageFileName = 'business-' . $businessId . '-' . $photoFileName;
        $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $imageFileName;

        $resCurl = curl_init($imageURL);
        $fpImage = fopen($imagePath, 'wb');

        curl_setopt($resCurl, CURLOPT_FILE, $fpImage);
        curl_setopt($resCurl, CURLOPT_HEADER, 0);
        curl_exec($resCurl);
        curl_close($resCurl);
        fclose($fpImage);

        return $imageFileName;
    }
}

?>