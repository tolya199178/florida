<?php

/**
 * Controller interface for Packages management.
 */

/**
 * Package Controller class to provide access to controller actions for clients.
 * The controller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/backend.php?/package/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/backend.php?/package/edit/package_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /package/edit/package_id/99/ will invoke PackageController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /package/edit/package_id/99/ will pass $_GET['Packagepackage_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class PackageadminController extends BackEndController
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
        $this->imagesDirPath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/package';
        $this->thumbnailsDirPath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/package/thumbnails';
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

            // delegate to Package model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('edit'),
            ),

            // delegate to Package model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


    /**
     * Creates a new package record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the package details capture form
     * ... - the (subsequent) POST request saves the submitted post data as a package record.
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the Package validation (Package::rules())
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionCreate()
    {

        $packageModel = new Package();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($packageModel);

        if(isset($_POST['Package']))
        {

            $packageModel->attributes = $_POST['Package'];


            $uploadedFile = CUploadedFile::getInstance($packageModel,'fldUploadImage');

            if(!empty($uploadedFile))  // check if uploaded file is set or not
            {
                // Save the image file name
                $packageModel->package_image = 'package-'.$packageModel->package_id.'-'.$uploadedFile->name;
            }

            if($packageModel->save()) {
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $packageModel->package_image;

                        // Save the new uploaded image
                    $uploadedFile->saveAs($imagePath);

                    $this->createThumbnail($packageModel->package_image);
                }

                // Save package items
                $k = 0;
                foreach($_POST['item_type_id'] as $item_type_id) {
                    // quantity defaults to 0
                    $quantity = isset($_POST['item_value'][$k]) ? (int)$_POST['item_value'][$k] : 0;
                    if($quantity < 0) {
                        //quantity is never less than 0
                        $quantity = 0;
                    }

                    // finds if a record already exists in package_items for this item_type and package
                    $itemModel = PackageItem::model()->findByAttributes(
                            array('package_id' => $packageModel->package_id, 'item_type_id' => $item_type_id)
                        );

                    if($quantity > 0) {
                       if(!$itemModel) {
                           // if there isn't a record in package_items creates a new one
                           $itemModel = new PackageItem();
                           $itemModel['package_id'] = $packageModel->package_id;
                           $itemModel['item_type_id'] = $item_type_id;
                       }
                       $itemModel['quantity'] = $quantity;
                       $itemModel->save();
                    } else if($itemModel) {
                        // if quantity is 0 and a record in package_items deletes the record
                        $itemModel->delete();
                    }
                    $k++;
                }

                $this->redirect(array('index'));
            }
            else {
                Yii::app()->user->setFlash('error', "Error creating a package record.'");
            }


        }

        // Show the details screen
        $this->render('details',array(
            'model'=>$packageModel,
            'itemTypes' => PackageItemType::model()->findAll(),
        ));

    }


    /**
     * Updates an existing pacjages record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the requested packages
     * ...   details capture form
     * ... - the (subsequent) POST request saves the submitted post data for
     * ...   the existing package record
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the Package validation (Package::rules())
     *
     * @param integer $package_id the ID of the model to be updated
     *
     * @return <none> <none>
     * @access public
     */
    public function actionEdit($package_id)
    {

        $packageModel = Package::model()->findByPk((int) $package_id);

        if($packageModel===null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($packageModel);


        if(isset($_POST['Package']))
        {
            // Assign all fields from the form
            $packageModel->attributes = $_POST['Package'];

            $uploadedFile = CUploadedFile::getInstance($packageModel,'fldUploadImage');

             // Make a note of the existing image file name. It will be deleted soon.
            $oldImageFileName = $packageModel->package_image;

            if(!empty($uploadedFile))  // check if uploaded file is set or not
            {
                // Save the image file name
                $packageModel->package_image = 'package-'.$packageModel->package_id.'-'.$uploadedFile->name;
            }

            if($packageModel->save())
            {
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {

                    $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $packageModel->package_image;

                    // Remove existing images
                    if (!empty($oldImageFileName))
                    {
                        $this->deleteImages($oldImageFileName);
                    }

                    // Save the new uploaded image
                    $uploadedFile->saveAs($imagePath);

                    $this->createThumbnail($packageModel->package_image);

                }

                // Save package items
                $k = 0;
                foreach($_POST['item_type_id'] as $item_type_id) {
                    // quantity defaults to 0
                    $quantity = isset($_POST['item_value'][$k]) ? (int)$_POST['item_value'][$k] : 0;
                    if($quantity < 0) {
                        //quantity is never less than 0
                        $quantity = 0;
                    }

                    // finds if a record already exists in package_items for this item_type and package
                    $itemModel = PackageItem::model()->findByAttributes(
                            array('package_id' => $packageModel->package_id, 'item_type_id' => $item_type_id)
                        );

                    if($quantity > 0) {
                       if(!$itemModel) {
                           // if there isn't a record in package_items creates a new one
                           $itemModel = new PackageItem();
                           $itemModel['package_id'] = $packageModel->package_id;
                           $itemModel['item_type_id'] = $item_type_id;
                       }
                       $itemModel['quantity'] = $quantity;
                       $itemModel->save();
                    } else if($itemModel) {
                        // if quantity is 0 and a record in package_items deletes the record
                        $itemModel->delete();
                    }
                    $k++;
                }

                $this->redirect(array('index'));
            }
            else {
                Yii::app()->user->setFlash('error', "Error creating a package record.'");
            }

        }

        $this->render('details',array(
            'model'=>$packageModel,
            'itemTypes' => PackageItemType::model()->findAll(),
        ));
    }

    /**
     * Deletes an existing package record.
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
        $packageId = $_POST['package_id'];
        $packageModel = Package::model()->findByPk((int)$packageId);

        if ($packageModel == null)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid package"}';
            Yii::app()->end();
        }


        $result = $packageModel->delete();

        if ($result == false)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        else {
            $this->deleteImages($packageModel->package_image);
        }

        echo '{"result":"success", "message":""}';
        Yii::app()->end();

    }


    /**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by package
     * Does not perform any processing. Redirects to the desired action instead.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {
        // Default action is to show all packages.
        $this->redirect(array('list'));
    }

    /**
     * Show all packages. Renders the packages listing view.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {
        $dataProvider=new CActiveDataProvider('Package');
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Generates a JSON encoded list of all packages.
     * The output is customised for the datatables Jquery plugin.
     * http://www.datatables.net
     *
     * The table plugins send a request for a JSON list based on criteria
     * ...determined by default settings or packages bahaviour.
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
            $searchCriteria->addSearchCondition('package_name', $_POST['search']['value'], true);
        }


        $lisPackages  = Package::model()->findAll($searchCriteria);

        $countRows 		            = Package::model()->count();
        $countTotalRecords 		    = Package::model()->count();

        /*
         * Output
         */
        $resultsAdvertTable = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($lisPackages as $package)
        {

            $rowResult = array(
                $package->attributes['package_id'],
                $package->attributes['package_name'],
                $package->attributes['package_price'],
            );

            $resultsAdvertTable['aaData'][] = $rowResult;

        }

        echo CJSON::encode($resultsAdvertTable);
        Yii::app()->end();

    }


    /**
     * Performs the AJAX validation.
     *
     * @param packageModel $packageModel the model to be validated
     *
     * @return string validation results message
     * @access protected
     */
    protected function performAjaxValidation($packageModel)
    {

        if(isset($_POST['ajax']) && $_POST['ajax']==='package-create-form')
        {
            echo CActiveForm::validate($packageModel);
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