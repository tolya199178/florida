<?php

/**
 * Banner Controller interface for the Frontend (Public) banners Module
 */


/**
 * BannerController is a class to provide access to controller actions for
 * ...general processing of user events. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/banner/banner/action
 * ...eg.
 * ...   http://mydomain/index.php?/banner
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. banner/banner/cart/ will invoke BannerController::actionCart()
 * ...(case is significant)
 *
 * @banner   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @banner Controllers
 * @version 1.0
 */

class BannerController extends Controller
{

    public 	$layout='//layouts/front';

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
     * Default controller action.
     * Shows list of all banners.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{


        CController::forward('/banner/banner/list/');


	}



    /**
     * List banners.
     * Shows list of all banners.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {

        $myBannerSummary     = $this->getBannerTop5();

        $listBannersData = Banner::model()->findAll();

        $arrayDataProvider=new CArrayDataProvider($listBannersData, array(
            'keyField' => 'banner_id',
            'id'=>'id',
            /* 'sort'=>array(
             'attributes'=>array(
                 'username', 'email',
             ),
            ), */
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));

        $bannerData          = array('mainview'        => 'banner_list',
                                     'myBannerSummary' => $this->getBannerTop5(),
                                     'arrayDataProvider'=>$arrayDataProvider);

        // Show the details screen
        $this->render('banner_main', array('data'=>$bannerData));

    }

    /**
     * Provide a summary of coupon activity for the current business.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     */
    private function getBannerTop5($businessId = null)
    {

        /**
         * If a business id is not supplied, then supply the coupon details for all
         * ...businesses managed by this user.
        */

        if ($businessId === null)
        {
            // lists certificates of all business of the current user
            $inDdbCriteria              = new CDbCriteria();
            $inDdbCriteria->with        = array('businessUsers');
            $inDdbCriteria->condition   = "businessUsers.user_id = :user_id";
            $inDdbCriteria->params      = array(':user_id' => Yii::app()->user->id);

            $businessList               = Business::model()->findAll($inDdbCriteria);
            $businessIds                = array();

            foreach ($businessList as $businessItem)
            {
                array_push($businessIds, $businessItem['business_id']);
            }
        }
        else
        {

            /*
             * Push the filtered business into the business list.
            */

            $businessIds                = array();
            array_push($businessIds, $businessId);
        }

        $lstBanners = Yii::app()->db->createCommand()
                                    ->select('banner_id, banner_title')
                                    ->from('tbl_banner')
                                    ->where(array('in', 'business_id', $businessIds))
                                    ->limit('5')
                                    ->order('created_time DESC')
                                    ->queryAll();

        return $lstBanners;

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
	public function actionAdd()
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

	    // Get the list of users's business

	    $dbCriteria                = new CDbCriteria();
	    $dbCriteria->with          = array('businessUsers');
	    $dbCriteria->condition     = "businessUsers.user_id = :user_id";
	    $dbCriteria->params        = array(':user_id' => Yii::app()->user->id);

	    $businessList              = Business::model()->findAll($dbCriteria);
	    $myBusinessList           = array();

	    foreach($businessList as $businessItem) {
	        $myBusinessList[$businessItem->business_id] = CHtml::encode($businessItem->business_name);
	    }

	    $bannerData          = array('mainview'        => 'details',
	                                 'model'           => $bannerModel,
	                                 'myBannerSummary' => $this->getBannerTop5(),
	                                 'myBusinessList'  => $myBusinessList);

	    // Show the details screen
	    $this->render('banner_main', array('data'=>$bannerData));

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
	public function actionUpdatebanner($banner_id)
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

	            $this->redirect(array('index'));

	        }
	        else {
	            Yii::app()->user->setFlash('error', "Error creating a banner record.'");
	        }

	    }

	    // Get the list of users's business
	    $dbCriteria                = new CDbCriteria();
	    $dbCriteria->with          = array('businessUsers');
	    $dbCriteria->condition     = "businessUsers.user_id = :user_id";
	    $dbCriteria->params        = array(':user_id' => Yii::app()->user->id);

	    $businessList              = Business::model()->findAll($dbCriteria);
	    $myBusinessList            = array();

	    foreach($businessList as $businessItem) {
	        $myBusinessList[$businessItem->business_id] = CHtml::encode($businessItem->business_name);
	    }


	    $bannerData          = array('mainview'        => 'details',
                        	         'model'           => $bannerModel,
                        	         'myBannerSummary' => $this->getBannerTop5(),
	                                 'myBusinessList'  => $myBusinessList);

	    // Show the details screen
	    $this->render('banner_main', array('data'=>$bannerData));

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

	    if(Yii::app()->request->isPostRequest)
	    {

    	    $bannerId = $_GET['id'];
    	    $bannerModel = Banner::model()->findByPk($bannerId);

    	    if ($bannerModel == null)
    	    {
    	        header("Content-type: application/json");
    	        echo '{"result":"fail", "message":"Invalid banner"}';
    	        Yii::app()->end();
    	    }

    	    if ($bannerModel->printed == 'Y')
    	    {
    	        header("Content-type: application/json");
    	        echo '{"result":"fail", "message":"You cannot delete a printed banner."}';
    	        Yii::app()->end();
    	    }

    	    // TODO: Retain this, until the use of expiry date is confirmed by client
    // 	    $expiryDate = strtotime($bannerModel->banner_expiry);

    // 	    if(time() > $expiryDate)
    // 	    {
    // 	        header("Content-type: application/json");
    // 	        echo '{"result":"fail", "message":"You cannot delete a printed banner."}';
    // 	        Yii::app()->end();
    // 	    }


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
        else
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }


	}

	/**
	 * Print a banner.
	 *
	 * @param <none> <none>
	 *
	 * @return string $result JSON encoded result and message
	 * @access public
	 */
	public function actionPrint()
	{

	    $bannerId = $_GET['banner_id'];
	    $bannerModel = Banner::model()->findByPk($bannerId);

	    if ($bannerModel == null)
	    {
	        throw new CHttpException(404,'The requested banner was not found.');
	        Yii::app()->end();
	    }

	    if ($bannerModel->printed == 'Y')
	    {
	        throw new CHttpException(400,'Invalid request. The requested banner is already printed.');
	        Yii::app()->end();
	    }


// 	    // Random code from here :
// 	    // http://stackoverflow.com/questions/3521621
// 	    $bannerCode = strtoupper(substr(md5(time().rand(10000,99999)), 0, 10));


	    // Show the details screen
	    $this->render('banner_print', array('model'=>$bannerModel));


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