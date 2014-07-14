<?php

/**
 * Controller interface for Advertisement management.
 */

/**
 * Advertisement Controller class to provide access to controller actions for clients.
 * The controller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/advertisement/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/advertisement/edit/advertisement_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /advertisement/edit/advertisement_id/99/ will invoke AdvertisementController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /advertisement/edit/advertisement_id/99/ will pass $_GET['advertisement_id'] = 99
 *
 * @package   Controllers
 * @author    Jan <jvjunsay@gmail.com>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class AdvertisementController extends BackEndController
{

    /**
     * @var string imagesDirPath Directory where Advertisement images will be stored
     * @access private
     */
    private $imagesDirPath;

    /**
     * @var string imagesDirPath Directory where Advertisement image thumbnails will be stored
     * @access private
     */
    private $thumbnailsDirPath;

    /**
     * @var string thumbnailWidth thumbnail width
     * @access private
     */
    private $thumbnailWidth     = 100;
    /**
     * @var string thumbnailWidth thumbnail width
     * @access private
     */
    private $thumbnailHeight    = 100;

    /**
     * Controller initailisation routines to set up the controller
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
     */
    public function init()
    {
        $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/advertisement';
        $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/advertisement/thumbnails';

        /*
         *     Small-s- 100px(width)
         *     Medum-m- 240px(width)
         *     Large-l- 600px(width)
         */
    }



    /**
     * Specify a list of filters to apply to action requests
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Override CController access rules and provide base rules for derived class.
     * All derived classes will automatically inherit the access rules provided.
     *
     * @param <none> <none>
     *
     * @return array list of accessrules to apply
     * @access public
     */
    /*
     * TODO: Convert this to use RBAC
     */
    public function accessRules()
    {

        // echo Yii::app()->user->isSuperAdmin();exit;

        return array(
            // Admin has full access. Applies to all controller action.
            array(
                'allow',
                'expression' =>'Yii::app()->user->isSuperAdmin()',
                // 'actions'    =>array('create'),

            ),

            // delegate to advertisement model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('edit'),
            ),

            // delegate to advertisement model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


    /**
     * Creates a new advertisement record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the advertisement details capture form
     * ... - the (subsequent) POST request saves the submitted post data as a Advertisement record.
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the Advertisement validation (Advertisement::rules())
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionCreate()
    {

        $advertisementModel  = new Advertisement();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($advertisementModel);

        if(isset($_POST['Advertisement']))
        {

            $advertisementModel->attributes             = $_POST['Advertisement'];

            $uploadedFile = CUploadedFile::getInstance($advertisementModel,'fldUploadImage');

            if($advertisementModel->save())
            {
                $imageFileName = 'advertisement-'.$advertisementModel->advertisement_id.'-'.$uploadedFile->name;
                $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs($imagePath);
                    $advertisementModel->image = $imageFileName;

                    $this->createThumbnail($imageFileName);

                    $advertisementModel->save();
                }

                $this->redirect(array('index'));

            }
            else {
                Yii::app()->user->setFlash('error', "Error creating a advertisement record.'");
            }


        }

        $advertisementModel->published='N';
        // Show the details screen
        $this->render('details',array(
            'model'=>$advertisementModel,
        ));

    }


    /**
     * Updates an existing advertisement record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the requested advertisements
     * ...   details capture form
     * ... - the (subsequent) POST request saves the submitted post data for
     * ...   the existing Advertisement record
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the Advertisement validation (Advertisement::rules())
     *
     * @param integer $advertisement_id the ID of the model to be updated
     *
     * @return <none> <none>
     * @access public
     */
    public function actionEdit($advertisement_id)
    {

        $advertisementModel = Advertisement::model()->findByPk((int) $advertisement_id);
        if($advertisementModel===null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($advertisementModel);


        if(isset($_POST['Advertisement']))
        {
            // Assign all fields from the form
            $advertisementModel->attributes             = $_POST['Advertisement'];

            $uploadedFile = CUploadedFile::getInstance($advertisementModel,'fldUploadImage');

            // Make a note of the existing image file name. It will be deleted soon.
            $oldImageFileName = $advertisementModel->image;

            if(!empty($uploadedFile))  // check if uploaded file is set or not
            {
                // Save the image file name
                $advertisementModel->image = 'advertisement-'.$advertisementModel->advertisement_id.'-'.$uploadedFile->name;
            }

            if($advertisementModel->save())
            {

                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {

                    $imageFileName = 'advertisement-'.$advertisementModel->advertisement_id.'-'.$uploadedFile->name;
                    $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

                    // Remove existing images
                    if (!empty($oldImageFileName))
                    {
                        $this->deleteImages($oldImageFileName);
                    }

                    // Save the new uploaded image
                    $uploadedFile->saveAs($imagePath);

                    $this->createThumbnail($imageFileName);
                }

                $this->redirect(array('index'));

            }
            else {
                Yii::app()->user->setFlash('error', "Error creating a advertisement record.'");
            }

        }

        $this->render('details',array(
            'model'=>$advertisementModel,
        ));
    }

    /**
     * Deletes an existing advertisement record.
     * ...As an additional safety measure, only POST requests are processed.
     * ...Currently, instead of physically deleting the entry, the record is
     * ...modified with the status fields set to 'deleted'
     * ...We also expect a JSON request only, and return a JSON string providing
     * ...outcome details.
     *
     * @param <none> <none>
     *
     * @return string $result JSON encoded result and message
     * @access public
     */
    public function actionDelete()
    {

        // TODO: add proper error message . iether flash or raiseerror. Might
        // be difficult when sending ajax response.

        // TODO: Only process ajax request
        $advertisementId = $_POST['advertisement_id'];
        $advertisementModel = Advertisement::model()->findByPk((int)$advertisementId);

        if ($advertisementModel == null)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid advertisement"}';
            Yii::app()->end();
        }


        $result = $advertisementModel->delete();

        if ($result == false)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        else
        {
            $this->deleteImages($advertisementModel->image);
        }



        echo '{"result":"success", "message":""}';
        Yii::app()->end();

    }


    /**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by advertisement
     * Does not perform any processing. Redirects to the desired action instead.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {
        // Default action is to show all advertisement.
        $this->redirect(array('list'));
    }


    /**
     * Show all advertisement. Renders the advertisement listing view.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {
        $dataProvider=new CActiveDataProvider('Advertisement');
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Generates a JSON encoded list of all advertisement.
     * The output is customised for the datatables Jquery plugin.
     * http://www.datatables.net
     *
     * The table plugins send a request for a JSON list based on criteria
     * ...determined by default settings or advertisement bahaviour.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionListjson()
    {

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        // Paging criteria
        // Set defaults
        $limitStart 	           = isset($_POST['start'])?$_POST['start']:0;
        $limitItems 	           = isset($_POST['length'])?$_POST['length']:Yii::app()->params['PAGESIZEREC'];

        $searchCriteria->limit 		 = $limitItems;
        $searchCriteria->offset 	 = $limitStart;


        // Only do livesearch if the keyword length < 2 characters
        if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
        {
            $searchCriteria->addSearchCondition('t.title', $_POST['search']['value'], true);
        }


        $listAdvertisement          = Advertisement::model()->findAll($searchCriteria);

        $countRows 		            = Advertisement::model()->count($searchCriteria);;
        $countTotalRecords 		    = Advertisement::model()->count();

        /*
         * Output
         */
        $resultsAdvertTable = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($listAdvertisement as $itemAdvertisment)
        {

            /* check if business_id is empty */
            $businessName ='';

            if(isset($itemAdvertisment->attributes['business_id']))
            {
                $businessName = $itemAdvertisment->business->business_name;
            }

            /* check if business_id is empty */
            $businessName ='';
            if(!empty($itemAdvertisment->attributes['business_id']))
            {
                $businessName = $itemAdvertisment->business->business_name;
            }


            $rowResult = array(
                $itemAdvertisment->attributes['advertisement_id'],
                $itemAdvertisment->attributes['title'],
                $itemAdvertisment->attributes['content'],
                $businessName,
                $itemAdvertisment->attributes['ads_views'],
                $itemAdvertisment->attributes['ads_clicks'],
                $itemAdvertisment->attributes['maximum_ads_views'],
                $itemAdvertisment->attributes['maximum_ads_clicks'],
                ''
            );

            $resultsAdvertTable['aaData'][] = $rowResult;

        }

        echo CJSON::encode($resultsAdvertTable);
        Yii::app()->end();

    }


    /**
     * Performs the AJAX validation.
     *
     * @param Advertisement $advertisementModel the model to be validated
     *
     * @return string validation results message
     * @access protected
     */
    protected function performAjaxValidation($advertisementModel)
    {


        if(isset($_POST['ajax']) && $_POST['ajax']==='advertisement-details-form')
        {
            echo CActiveForm::validate($advertisementModel);
            Yii::app()->end();
        }
    }

    /**
     * Delete images for the advertisement. Normally invoked when advertisement is being deleted.
     *
     * @param string $imageFileName the name of the file
     *
     * @return <none> <none>
     * @access public
     */
    private function deleteImages($imageFileName)
    {
        $imagePath          = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        @unlink($imagePath);

        $thumbnailPath     = $this->thumbnailsDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        @unlink($thumbnailPath);
    }

    /**
     * Create a thumbnail image from the filename give, Store it in the thumbnails folder.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    private function createThumbnail($imageFileName, $sizeWidth = 0, $sizeHeight = 0)
    {

        if ($sizeWidth == 0)
        {
            $sizeWidth     = $this->thumbnailWidth;
        }
        if ($sizeHeight == 0)
        {
            $sizeHeight    = $this->thumbnailHeight;
        }

        $thumbnailPath     = $this->thumbnailsDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        $imagePath         = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

        $imgThumbnail              = new Thumbnail;
        $imgThumbnail->PathImgOld  = $imagePath;
        $imgThumbnail->PathImgNew  = $thumbnailPath;

        $imgThumbnail->NewWidth    = $sizeWidth;
        $imgThumbnail->NewHeight   = $sizeHeight;

        $result = $imgThumbnail->create_thumbnail_images();

        if (!$result)
        {
            return false;
        }
        else
        {
            return true;
        }

    }

}
