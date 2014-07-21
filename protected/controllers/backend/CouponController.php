<?php

/**
 * Controller interface for Coupon management.
 */

/**
 * Coupon Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/coupon/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/coupon/edit/coupon_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /coupon/edit/coupon_id/99/ will invoke CouponController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /coupon/edit/coupon_id/99/ will pass $_GET['coupon_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class CouponController extends BackEndController
{

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

            // delegate to coupon model methods to determine ownership
            array(
                'allow',
                'expression' =>'CouponAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("coupon_id"))',
                'actions'    =>array('edit'),
            ),

            // delegate to coupon model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


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
	public function actionCreate()
	{

		$couponModel = new Coupon;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($couponModel);

	    if(isset($_POST['Coupon']))
	    {

	        $couponModel->attributes=$_POST['Coupon'];

	        $uploadedFile = CUploadedFile::getInstance($couponModel,'fldUploadImage');

	        if($couponModel->save())
	        {

                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $imageFileName = 'coupon-'.$couponModel->coupon_id.'-'.$uploadedFile->name;
                    $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

                    $uploadedFile->saveAs($imagePath);
                    $couponModel->coupon_photo = $imageFileName;

                    $this->createThumbnail($imageFileName);

                    $couponModel->save();
                }

	            $this->redirect(array('index'));

	        }
	        else {
                Yii::app()->user->setFlash('error', "Error creating a coupon record.'");
	        }


	    }

	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$couponModel,
	    ));

	}


	/**
	 * Updates an existing coupon record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested coupon's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Coupon record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Coupon validation (Coupon::rules())
	 *
	 * @param integer $coupon_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($coupon_id)
	{

		$couponModel = Coupon::model()->findByPk($coupon_id);
		if($couponModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($couponModel);

		if(isset($_POST['Coupon']))
		{
            // Assign all fields from the form
		    $couponModel->attributes=$_POST['Coupon'];

		    $uploadedFile = CUploadedFile::getInstance($couponModel,'fldUploadImage');

		    // Make a note of the existing image file name. It will be deleted soon.
		    $oldImageFileName = $couponModel->coupon_photo;

		    if(!empty($uploadedFile))  // check if uploaded file is set or not
		    {
		        // Save the image file name
		        $couponModel->coupon_photo = 'coupon-'.$couponModel->coupon_id.'-'.$uploadedFile->name;
		    }

		    if($couponModel->save())
		    {

		        if(!empty($uploadedFile))  // check if uploaded file is set or not
		        {

		            $imageFileName = 'coupon-'.$couponModel->coupon_id.'-'.$uploadedFile->name;
		            $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

		            // Remove existing images
		            if (!empty($oldImageFileName))
		            {
		                $this->deleteImages($oldImageFileName);
		            }

		            // Save the new uploaded image
		            $uploadedFile->saveAs($imagePath);

		            $this->createThumbnail($imageFileName);

		            $couponModel->save();


		        }

		        $this->redirect(array('index'));

		    }
		    else {
		        Yii::app()->user->setFlash('error', "Error creating a coupon record.'");
		    }

		}

		$this->render('details',array(
			'model'=>$couponModel,
		));
	}

	/**
	 * Deletes an existing coupon record.
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
        $couponId = $_POST['coupon_id'];
        $couponModel = Coupon::model()->findByPk($couponId);

        if ($couponModel == null)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid coupon"}';
            Yii::app()->end();
        }


        $result = $couponModel->delete();

        if ($result == false)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        else
        {
            $this->deleteImages($couponModel->image);
        }



        echo '{"result":"success", "message":""}';
        Yii::app()->end();

	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by coupon
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all coupons.
	    $this->redirect(array('list'));
	}


	/**
	 * Show all coupons. Renders the coupon listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('Coupon');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Generates a JSON encoded list of all coupons.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 *
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or coupon bahaviour.
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
        $limitStart 	           = isset($_POST['start'])?$_POST['start']:0;
        $limitItems 	           = isset($_POST['length'])?$_POST['length']:Yii::app()->params['PAGESIZEREC'];

        $searchCriteria->limit 		 = $limitItems;
        $searchCriteria->offset 	 = $limitStart;

         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
         {
             $searchCriteria->addSearchCondition('t.coupon_name', $_POST['search']['value'], true);
         }


        $coupon_list      = Coupon::model()->findAll($searchCriteria);

        $rows_count 		= Coupon::model()->count($searchCriteria);;
        $total_records 		= Coupon::model()->count();

        /*
         * Output
         */
        $output = array(
            "iTotalRecords"         => $rows_count,
            "iTotalDisplayRecords"  => $total_records,
            "aaData"                => array()
        );

        foreach($coupon_list as $r){

            $row = array($r->attributes['coupon_id'],
                         $r->attributes['coupon_name'],
                         $r->attributes['coupon_description'],
                         $r->attributes['coupon_type'],
                         $r->attributes['coupon_code'],
                         $r->attributes['coupon_expiry'],
                         $r->attributes['printed'],
                         ''
                        );
            $output['aaData'][] = $row;

        }


        echo json_encode($output);


	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Coupon $couponModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($couponModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='coupon-form')
		{
			echo CActiveForm::validate($couponModel);
			Yii::app()->end();
		}
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
