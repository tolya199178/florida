<?php

/**
 * Controller interface for User management.
 */

/**
 * User Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/user/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/user/edit/user_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /user/edit/user_id/99/ will invoke UserController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /user/edit/user_id/99/ will pass $_GET['user_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class UserController extends BackEndController
{

    /**
     * @var string imagesDirPath Directory where User images will be stored
     * @access private
     */
    private $imagesDirPath;

    /**
     * @var string imagesDirPath Directory where User image thumbnails will be stored
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
        $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/user';
        $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/user/thumbnails';

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
	 * Creates a new user record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the user details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a User record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the User validation (User::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{

		$userModel=new User;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($userModel);

	    if(isset($_POST['User']))
	    {

	        $userModel->attributes           =$_POST['User'];
	        $userModel->places_visited       = serialize($_POST['User']['places_visited']);
	        $userModel->places_want_to_visit = serialize($_POST['User']['places_want_to_visit']);


	        $uploadedFile = CUploadedFile::getInstance($userModel,'fldUploadImage');

	        if($userModel->save())
	        {

	            if(!empty($uploadedFile))  // check if uploaded file is set or not
	            {

	                $imageFileName = 'user-'.$userModel->user_id.'-'.$uploadedFile->name;
	                $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

	                $uploadedFile->saveAs($imagePath);
	                $userModel->image = $imageFileName;

	                $this->createThumbnail($imageFileName);

	                $userModel->save();
	            }

	            $this->redirect(array('index'));

	        }
	        else {
	            Yii::app()->user->setFlash('error', "Error creating a user record.'");
	        }


	    }






	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$userModel,
	    ));

	}


	/**
	 * Updates an existing user record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested user's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing User record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the User validation (User::rules())
	 *
	 * @param integer $user_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($user_id)
	{

		$userModel = User::model()->findByPk($user_id);
		if($userModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($userModel);

		if(isset($_POST['User']))
		{

		    // Unset the password if it is not supplied so that it is not
		    // ...overwritten by an empty password.
		    if (empty($_POST['User']['password']))
		        unset($_POST['User']['password']);

			$userModel->attributes           = $_POST['User'];
			$userModel->places_visited       = serialize($_POST['User']['places_visited']);
			$userModel->places_want_to_visit = serialize($_POST['User']['places_want_to_visit']);

			$uploadedFile = CUploadedFile::getInstance($userModel,'fldUploadImage');


			// Make a note of the existing image file name. It will be deleted soon.
			$oldImageFileName = $userModel->image;

			if(!empty($uploadedFile))  // check if uploaded file is set or not
			{
			    // Save the image file name
			    $userModel->image = 'user-'.$userModel->user_id.'-'.$uploadedFile->name;
			}

			if($userModel->save())
			{

			    if(!empty($uploadedFile))  // check if uploaded file is set or not
			    {

			        $imageFileName = 'user-'.$userModel->user_id.'-'.$uploadedFile->name;
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

			    Yii::app()->user->setFlash('error', "Error creating a user record.'");
			}





		}

 		$userModel->places_visited           = unserialize($userModel->places_visited);
 		$userModel->places_want_to_visit     = unserialize($userModel->places_want_to_visit);

		$userModel->password                 = '';            // Don't show the password
		$this->render('details',array('model'=>$userModel));
	}

	/**
	 * Deletes an existing user record.
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

	    // todo: add proper error message . iether flash or raiseerror. Might
	    // be difficult is sending ajax response.

	    // TODO: Only process ajax request
        $userId = $_POST['user_id'];
        $userModel = User::model()->findByPk($userId);

        // /////////////////////////////////////////////////////////////////
        // Disable deletion of superadmin user.
        // /////////////////////////////////////////////////////////////////
        if ($userModel->attributes['user_type'] == User::USER_TYPE_SUPERADMIN) {
            echo '{"result":"fail", "message":"Operation not supported"}';
            Yii::app()->end();
        }

        if ($userModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid user"}';
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////
        // Instead of deleting the entry, the record is modified with the
        // ...status fields set to 'deleted'
        // /////////////////////////////////////////////////////////////////
        // $result = $user->delete();

        $userModel->status = 'deleted';

        $result = $userModel->save();


        if ($result == false) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }

        echo '{"result":"success", "message":""}';

	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by user
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all users.
	    $this->redirect(array('list'));
	}


	/**
	 * Show all users. Renders the user listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('User');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Generates a JSON encoded list of all users.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 *
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or user bahaviour.
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

         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2)) {
             $searchCriteria->addSearchCondition('t.first_name', $_POST['search']['value'], true, 'OR');
             $searchCriteria->addSearchCondition('t.last_name',  $_POST['search']['value'], true, 'OR');

         }


        $user_list=User::model()->findAll($searchCriteria);

        $rows_count 		= User::model()->count($searchCriteria);;
        $total_records 		= User::model()->count();


        echo '{"iTotalRecords":'.$rows_count.',
        		"iTotalDisplayRecords":'.$rows_count.',
        		"aaData":[';
        $f=0;
        foreach($user_list as $r){

            if($f++) echo ',';
            echo   '[' .
                '"'  .$r->attributes['user_id'] .'"'
              . ',"' .$r->attributes['user_type'] .'"'
              . ',"' .$r->attributes['user_name'] .'"'
              . ',"' .$r->attributes['first_name'] .' '. $r->attributes['last_name'] .'"'
              . ',"' .$r->attributes['status'] .'"'
              . ',"' .$r->attributes['last_login'] .'"'
            . ',""'
            . ']';
        }
        echo ']}';



	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param User $userModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($userModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($userModel);
			Yii::app()->end();
		}
	}

	/**
	 * Delete images for the user. Normally invoked when user is being deleted.
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
	 * Renders JSON results of user search in {id,text} format.
	 * Used for dropdowns
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAutocompletelist()
	{

        $strSearchFilter = $_GET['query'];

        // Don't process short request to prevent load on the system.
        if (strlen($strSearchFilter) < 3)
        {
            header('Content-type: application/json');
            return "";
            Yii::app()->end();

        }

        $lstUsers = Yii::app()->db
                              ->createCommand()
                              ->select('user_id AS id, CONCAT(first_name, " ", last_name) AS text')
                              ->from('tbl_user user')
                              ->where(array('LIKE', 'first_name', '%'.$_GET['query'].'%'))
                              ->orWhere(array('OR LIKE', 'last_name', '%'.$_GET['query'].'%'))
                              ->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($lstUsers);

	}

}
