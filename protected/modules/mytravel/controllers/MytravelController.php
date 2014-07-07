<?php

/**
 * Mytravel Controller interface for the Frontend (Public) Mytravels Module
 */


/**
 * MytravelController is a class to provide access to controller actions for general
 * ..processing of user friends actions. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/mytravel/mytravel/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/mytravel/mytravel/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /mytravel/mytravel/show/name/toms/ will invoke MyFriendController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /mytravel/mytravel/show/name/toms/ will pass $_GET['name'] = 'tom'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @version   1.0
 */

class MytravelController extends Controller
{


    public 	$layout='//layouts/front';

    /**
     * Default controller action.
     * Shows the my travel dashboard page
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{

	    $this->redirect(array('/mytravel/mytravel/show'));

	    Yii::app()->end();

	}

	/**
	 * Displays travel dashboard
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionShow()
	{

        // /////////////////////////////////////////////////////////////////////
        // Redirect non-logged in users to the login page
        // /////////////////////////////////////////////////////////////////////
        if (Yii::app()->user->isGuest)         // User is not logged in
        {
            $this->redirect("login");
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////////
        // Get the login details from the WebUser component
        // /////////////////////////////////////////////////////////////////////
        $userId = Yii::app()->user->id;

        if ($userId === null)         // User is not known
        {
            $this->redirect("login");
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////////
        // Load the user details
        // /////////////////////////////////////////////////////////////////////
        $userModel = User::model()->findByPk($userId);
        if ($userModel === null) {
            $this->redirect("login");
        }

        $dbCriteria             = new CDbCriteria;
        $dbCriteria->condition  = 'user_id = :user_id';
        $dbCriteria->params     = array(':user_id'=>Yii::app()->user->id);
        $dbCriteria->limit      = 10;
        $dbCriteria->order      = 'created_date  DESC';

        $lstMyTrips = Trip::model()->findAll($dbCriteria);

        $lstMyTravels = Trip::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));



        // Show the dashboard
        $this->render('mytravel_main', array(
                      'mainview'        => 'mytravels',
                      'data'            => array('myTrips'   => $lstMyTrips,
                                                 'myTravels' => $lstMyTravels)
                ));

	}


	/**
	 * Adds a new Trip.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAdd()
	{
	    // /////////////////////////////////////////////////////////////////////
	    // This function is only available to users that are logged in. Other
	    // ...users are given a friendly notice and gentle request to log in
	    // ...or join.
	    // /////////////////////////////////////////////////////////////////////
	    $userId = Yii::app()->user->id;

	    if ($userId === null)         // User is not known
	    {
	        Yii::app()->user->setFlash('warning','You must be logged in to perform this action.');
	        $this->redirect("login");
	        Yii::app()->end();
	    }

	    $tripModel = new Trip;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($tripModel);

	    if(isset($_POST['Trip']))
	    {

 	        $tripModel->attributes             = $_POST['Trip'];


	        if($tripModel->save())
	        {

	            Yii::app()->user->setFlash('success', "The trip details has been created.");

	            $this->redirect(array('/mytravel/mytravel/show'));

	        }
	        else {
	            Yii::app()->user->setFlash('error', "Error creating a trip record.");
	        }


	    }

	    $dbCriteria             = new CDbCriteria;
	    $dbCriteria->condition  = 'user_id = :user_id';
	    $dbCriteria->params     = array(':user_id'=>Yii::app()->user->id);
	    $dbCriteria->limit      = 10;
	    $dbCriteria->order      = 'created_date  DESC';

	    // Show the details screen
	    $lstMyTrips = Trip::model()->findAll($dbCriteria);

	    // Show the dashboard
	    $this->render('mytravel_main', array('mainview'        => 'details',
                                	         'data'            => array('myTrips'   => $lstMyTrips,
                                	                                    'model'     => $tripModel)
                                	    ));

	}

	/**
	 * Edits an existing Trip.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionManage()
	{
	    // /////////////////////////////////////////////////////////////////////
	    // This function is only available to users that are logged in. Other
	    // ...users are given a friendly notice and gentle request to log in
	    // ...or join.
	    // /////////////////////////////////////////////////////////////////////
	    $userId = Yii::app()->user->id;

	    if ($userId === null)         // User is not known
	    {
	        Yii::app()->user->setFlash('warning','You must be logged in to perform this action.');
	        $this->redirect("login");
	        Yii::app()->end();
	    }

	    $argTripId = Yii::app()->request->getQuery('trip', null);

	    if ($argTripId === null)         // User is not known
	    {
	        Yii::app()->user->setFlash('error','No trip indicated.');
	    }

	    $tripModel = Trip::model()->with('tripLegs','tripLegs.city')->findByPk( (int) $argTripId);

	    /* Check that the trip record is found. */
	    if ($tripModel === null)
	    {
	        throw new CHttpException(404, 'The requested record was not found.');
	    }

	    /* Only owners can edit their own trip */
	    if ($tripModel->user_id != $userId)
	    {
	        throw new CHttpException(403, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($tripModel);

	    if(isset($_POST['Trip']))
	    {

	        $tripModel->attributes             = $_POST['Trip'];


	        if($tripModel->save())
	        {

	            Yii::app()->user->setFlash('success', "The trip details has been created.");

	            $this->redirect(array('/mytravel/mytravel/show'));

	        }
	        else {
	            Yii::app()->user->setFlash('error', "Error creating a trip record.");
	        }


	    }

	    $dbCriteria             = new CDbCriteria;
	    $dbCriteria->condition  = 'user_id = :user_id';
	    $dbCriteria->params     = array(':user_id'=>Yii::app()->user->id);
	    $dbCriteria->limit      = 10;
	    $dbCriteria->order      = 'created_date  DESC';

	    // Show the details screen
	    $lstMyTrips = Trip::model()->findAll($dbCriteria);

	    // Show the dashboard
	    $this->render('mytravel_main', array('mainview'        => 'details',
	                                         'data'            => array('myTrips'   => $lstMyTrips,
	                                         'model'           => $tripModel)
	    ));

	}

	/**
	 * Adds a new Trip Leg.
	 * Leag interface is AJAX.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAddleg()
	{

	    // /////////////////////////////////////////////////////////////////////
	    // This function is only available to users that are logged in. Other
	    // ...users are given a friendly notice and gentle request to log in
	    // ...or join.
	    // /////////////////////////////////////////////////////////////////////
	    $userId = Yii::app()->user->id;

	    if ($userId === null)         // User is not known
	    {
	        Yii::app()->user->setFlash('warning','You must be logged in to perform this action.');
	        $this->redirect("login");
	        Yii::app()->end();
	    }

	    $argTripId = Yii::app()->request->getQuery('trip', null);

	    if ($argTripId === null)         // User is not known
	    {
	        Yii::app()->user->setFlash('error','No trip indicated.');
	    }

	    $modelTripLeg = new TripLeg;

	    /* Check that the trip record is found. */
	    if ($modelTripLeg === null)
	    {
	        throw new CHttpException(404, 'The requested record was not found.');
	    }

	    $modelTripLeg->trip_id = $argTripId;


	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($tripModel);

	    if(isset($_POST['TripLeg']))
	    {

 	        $modelTripLeg->attributes             = $_POST['TripLeg'];


 	        if($modelTripLeg->save())
 	        {
 	            Yii::app()->user->setFlash('success', "The trip details has been created.");
 	            $this->redirect(array('/mytravel/mytravel/manage/trip/'.$argTripId));

 	        }
 	        else {
 	            Yii::app()->user->setFlash('error', "Error creating a trip record.");
 	            print_r($modelTripLeg);
 	        }


	    }


	    // Show the dashboard
	    $this->renderPartial('trip_leg_details', array('model'=> $modelTripLeg));

	}

}