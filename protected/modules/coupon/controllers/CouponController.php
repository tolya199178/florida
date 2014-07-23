<?php

/**
 * Coupon Controller interface for the Frontend (Public) coupons Module
 */


/**
 * CouponController is a class to provide access to controller actions for
 * ...general processing of user events. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/coupon/coupon/action
 * ...eg.
 * ...   http://mydomain/index.php?/coupon
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. coupon/coupon/cart/ will invoke CouponController::actionCart()
 * ...(case is significant)
 *
 * @coupon   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @coupon Controllers
 * @version 1.0
 */

class CouponController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * @var string imagesDirPath Directory where Coupon images will be stored
     * @access private
     */
    private $imagesDirPath;

    /**
     * @var string imagesDirPath Directory where Coupon image thumbnails will be stored
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
        $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/coupon';
        $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/coupon/thumbnails';

        /*
         *     Small-s- 100px(width)
        *     Medum-m- 240px(width)
        *     Large-l- 600px(width)
        */
    }

    /**
     * Default controller action.
     * Shows list of all coupons.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{


        CController::forward('/coupon/coupon/list/');


	}



    /**
     * List coupons.
     * Shows list of all coupons.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {

        $myCouponSummary     = $this->getCouponSummary();

        $listCouponsData = Coupon::model()->findAll();

        $arrayDataProvider=new CArrayDataProvider($listCouponsData, array(
            'keyField' => 'coupon_id',
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

        $couponData          = array('mainview'        => 'coupon_list',
                                     'myCouponSummary' => $this->getCouponSummary(),
                                     'arrayDataProvider'=>$arrayDataProvider);

        // Show the details screen
        $this->render('coupon_main', array('data'=>$couponData));

    }

    /**
     * Provide a summary of coupon activity for the current business.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     */
    private function getCouponSummary($businessId = null)
    {

        $summaryResults = array();

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


        $dbCriteria                 = new CDbCriteria();
        $dbCriteria->addInCondition('business_id', $businessIds);

        $lstAllMyCertificates       = Coupon::model()->findAll($dbCriteria);

        $summaryResults             = array('countAll'          => 0,
            'countPrinted'      => 0,
            'valuePrinted'      => 0);

        foreach ($lstAllMyCertificates as $itemCertificate)
        {
            $summaryResults['countAll']++;

            if ($itemCertificate->printed == 'Y')
            {
                $summaryResults['countPrinted']++;
                $summaryResults['valuePrinted']++;

            }

        }

        return $summaryResults;

    }

	/**
	 * Creates a new coupon record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the coupon details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Coupon record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Coupon validation (Coupon::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreaterequest()
	{

		$couponModel = new Coupon('createbatch');

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($couponModel);

	    if(isset($_POST['Coupon']))
	    {

	        $uploadedFile = CUploadedFile::getInstance($couponModel,'fldUploadImage');

	        $countCouponsRequired = $_POST['Coupon']['fldCouponCreateCount'];

	        // Create the coupons one by one.
	        for ($indexCoupon = 0; $indexCoupon < $countCouponsRequired; $indexCoupon++)
	        {

	            // Random code from here :
	            // http://stackoverflow.com/questions/3521621
	            $couponCode = strtoupper(substr(md5(time().rand(10000,99999)), 0, 10));


                $itemCoupon = new Coupon;
                $itemCoupon->attributes = $_POST['Coupon'];
                $itemCoupon->coupon_code = $couponCode;


                if($itemCoupon->save())
                {

                    if(!empty($uploadedFile))  // check if uploaded file is set or not
                    {
                        $imageFileName = 'coupon-'.$itemCoupon->coupon_id.'-'.$uploadedFile->name;
                        $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

                        $uploadedFile->saveAs($imagePath);
                        $itemCoupon->coupon_photo = $imageFileName;

                        $this->createThumbnail($imageFileName);

                        $itemCoupon->save();
                    }

                }
                else {
                    Yii::app()->user->setFlash('error', "Error creating a coupon record.'");
                }

	        }

	        $this->redirect(array('index'));


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

	    $couponData          = array('mainview'        => 'createrequest',
	                                 'model'           => $couponModel,
	                                 'myCouponSummary' => $this->getCouponSummary(),
	                                 'myBusinessList'  => $myBusinessList);

	    // Show the details screen
	    $this->render('coupon_main', array('data'=>$couponData));

	}

    /**
     * Delete images for the coupon. Normally invoked when coupon is being deleted.
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

}