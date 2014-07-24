<?php

/**
 * Controller interface for Banneradmin management.
 */

/**
 * Banner Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/banner/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/banner/edit/banner_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /banner/edit/banner_id/99/ will invoke BannerController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /banner/edit/banner_id/99/ will pass $_GET['banner_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class BanneradminController extends BackEndController
{

    /**
     * @var string imagesDirPath Directory where Banner images will be stored
     * @access private
     */
    private $imagesDirPath;

    /**
     * @var string imagesDirPath Directory where Banner image thumbnails will be stored
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
        $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/banner';
        $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/banner/thumbnails';

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

            // delegate to banner model methods to determine ownership
            array(
                'allow',
                'expression' =>'BannerAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("banner_id"))',
                'actions'    =>array('edit'),
            ),

            // delegate to banner model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


	/**
	 * Creates a new banner record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the banner details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Banner record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Banner validation (Banner::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{

		$bannerModel = new Banner;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($bannerModel);

	    if(isset($_POST['Banner']))
	    {

	        $bannerModel->attributes=$_POST['Banner'];

	        $uploadedFile = CUploadedFile::getInstance($bannerModel,'fldUploadImage');

	        if($bannerModel->save())
	        {

	            /*
	             * process the banner photo
	             */
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $imageFileName = 'banner-'.$bannerModel->banner_id.'-'.$uploadedFile->name;
                    $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

                    $uploadedFile->saveAs($imagePath);
                    $bannerModel->banner_photo = $imageFileName;

                    $this->createThumbnail($imageFileName);

                    $bannerModel->save();
                }

                /*
                 * Save the pages that the banner is allocated to
                 */

                $lstBannerPages = explode(",", $_POST['lstBannerPages']);

                foreach ($lstBannerPages as $selectedPageId)
                {
                    $modelBannerPage                = new BannerPage;
                    $modelBannerPage->page_id       = $selectedPageId;
                    $modelBannerPage->banner_id     = $bannerModel->banner_id;

                    $modelBannerPage->save();
                }


	            $this->redirect(array('index'));

	        }
	        else {
                Yii::app()->user->setFlash('error', "Error creating a banner record.'");
	        }


	    }

	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$bannerModel,
	    ));

	}


	/**
	 * Updates an existing banner record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested banner's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Banner record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Banner validation (Banner::rules())
	 *
	 * @param integer $banner_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($banner_id)
	{

		$bannerModel = Banner::model()->findByPk($banner_id);
		if($bannerModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($bannerModel);

		if(isset($_POST['Banner']))
		{
            // Assign all fields from the form
		    $bannerModel->attributes=$_POST['Banner'];

		    $uploadedFile = CUploadedFile::getInstance($bannerModel,'fldUploadImage');

		    // Make a note of the existing image file name. It will be deleted soon.
		    $oldImageFileName = $bannerModel->banner_photo;

		    if(!empty($uploadedFile))  // check if uploaded file is set or not
		    {
		        // Save the image file name
		        $bannerModel->banner_photo = 'banner-'.$bannerModel->banner_id.'-'.$uploadedFile->name;
		    }

		    if($bannerModel->save())
		    {

		        if(!empty($uploadedFile))  // check if uploaded file is set or not
		        {

		            $imageFileName = 'banner-'.$bannerModel->banner_id.'-'.$uploadedFile->name;
		            $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

		            // Remove existing images
		            if (!empty($oldImageFileName))
		            {
		                $this->deleteImages($oldImageFileName);
		            }

		            // Save the new uploaded image
		            $uploadedFile->saveAs($imagePath);

		            $this->createThumbnail($imageFileName);

		            $bannerModel->save();


		        }

		        /*
		         * Save the pages that the banner is allocated to
		        */
		        $lstBannerPages = explode(",", $_POST['lstBannerPages']);


		        /* Delete existing banner-page mappings for the banner */
		        $modelBannerPageDelete = BannerPage::model()->deleteAll("banner_id = :banner_id",
	                                                               array(':banner_id' => $bannerModel->banner_id
		                                                      ));

		        foreach ($lstBannerPages as $selectedPageId)
		        {
		            $modelBannerPage                = new BannerPage;
		            $modelBannerPage->page_id       = $selectedPageId;
		            $modelBannerPage->banner_id     = $bannerModel->banner_id;

		            $modelBannerPage->save();
		        }


		        $this->redirect(array('index'));

		    }
		    else {
		        Yii::app()->user->setFlash('error', "Error creating a banner record.'");
		    }

		}

		$this->render('details',array(
			'model'=>$bannerModel,
		));
	}

	/**
	 * Deletes an existing banner record.
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
        $bannerId = $_POST['banner_id'];
        $bannerModel = Banner::model()->findByPk($bannerId);

        if ($bannerModel == null)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid banner"}';
            Yii::app()->end();
        }


        $result = $bannerModel->delete();

        if ($result == false)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        else
        {
            $this->deleteImages($bannerModel->banner_photo);
        }



        echo '{"result":"success", "message":""}';
        Yii::app()->end();

	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by banner
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all banners.
	    $this->redirect(array('list'));
	}


	/**
	 * Show all banners. Renders the banner listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('Banner');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Generates a JSON encoded list of all banners.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 *
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or banner bahaviour.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionListjson() {

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        // Paging criteria
        // Set defaults
        $limitStart 	            = isset($_POST['start'])?$_POST['start']:0;
        $limitItems 	            = isset($_POST['length'])?$_POST['length']:Yii::app()->params['PAGESIZEREC'];

        $searchCriteria->limit      = $limitItems;
        $searchCriteria->offset     = $limitStart;

         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
         {
             $searchCriteria->addSearchCondition('t.banner_title', $_POST['search']['value'], true);
         }


        $listBanner                 = Banner::model()->findAll($searchCriteria);

        $countRows 		            = Banner::model()->count($searchCriteria);;
        $countTotalRecords 	        = Banner::model()->count();

        /*
         * Output
         */
        $resultsBannerTable = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($listBanner as $itemBanner){

            $rowResult = array($itemBanner->attributes['banner_id'],
                         $itemBanner->attributes['banner_title'],
                         $itemBanner->attributes['banner_url'],
                         $itemBanner->attributes['banner_status'],
                         ''
                        );
            $resultsBannerTable['aaData'][] = $rowResult;

        }


        echo CJSON::encode($resultsBannerTable);


	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Banner $bannerModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($bannerModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='banner-form')
		{
			echo CActiveForm::validate($bannerModel);
			Yii::app()->end();
		}
	}

	/**
	 * Delete images for the banner. Normally invoked when banner is being deleted.
	 *
	 * @param string $imageFileName the name of the file
	 *
	 * @return <none> <none>
	 * @access public
	 */
	private function deleteImages($imageFileName)
	{
        $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        @unlink($imagePath);

        $thumbnailPath     = $this->thumbnailsDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        @unlink($thumbnailPath);
	}

	/**
	 * Create a thumbnail image from the filename give, Store it in the thumnails folder.
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

	/**
	 * Renders JSON results of page search in {id,text} format.
	 * Used for dropdowns
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAutocompletepagelist()
	{

	    $strSearchFilter = $_GET['query'];

	    $lstPages = Yii::app()->db
                        	  ->createCommand()
                        	   ->select('page_id AS id, page_name AS text')
                        	   ->from('tbl_page')
                        	   ->where(array('LIKE', 'page_name', '%'.$_GET['query'].'%'))
                        	   ->queryAll();

	    header('Content-type: application/json');
	    echo CJSON::encode($lstPages);

	}

}
