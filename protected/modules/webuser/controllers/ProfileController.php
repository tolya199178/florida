<?php

/**
 * Profile Controller interface for the Frontend (Public) Webuser Module
 */


/**
 * ProfileController is a class to provide access to controller actions for general
 * ..processing of user profile actions. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/webuser/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/webuser/profile/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /business/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /business/profile/show/name/toms/ will pass $_GET['name'] = 'toms'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class ProfileController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * Adds a business to a user's profile
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionAddbusiness()
	{

		$argBusinessId = (int) Yii::app()->request->getQuery('business_id', null);

		$userId = Yii::app()->user->id;

		if ($userId === null)         // User is not known
		{
		    $jsonResult = '{"result":false,"message":"This functionality is only avalable to logged in users."}';
		    header('Content-Type: application/json');
		    echo CJSON::encode($jsonResult);
		    Yii::app()->end();
		}


		if ($argBusinessId)
		{
		    $modelBusiness = Business::model()->findByPk((int) $argBusinessId);

		    if ($modelBusiness === null)
		    {
		        $jsonResult = '{"result":false,"message":"Something went wrong. The requested business could not be found."}';
		        header('Content-Type: application/json');
		        echo CJSON::encode($jsonResult);
		        Yii::app()->end();
		    }
		    else
		    {
		        // Add the business to the user's profile. Don't do anything if the user is already subscribed.
		        // $modelBusinessSubscription = SubscribedBusiness::model()->findByAttributes(array('user_id'=> Yii::app()->user->id, 'business_id' => $argBusinessId));
		        $boolSubscribedStatus = SubscribedBusiness::isSubcribed(Yii::app()->user->id,$argBusinessId);

		        if ($boolSubscribedStatus === false)
		        {
		            $modelBusinessSubscription                  = new SubscribedBusiness;
                    $modelBusinessSubscription->user_id         = $userId;
                    $modelBusinessSubscription->business_id     = $argBusinessId;

                    if (!($modelBusinessSubscription->save()))
                    {
                        $jsonResult = '{"result":false,"message":"Something went wrong. The business could not be added to your profile."}';
                        header('Content-Type: application/json');
                        echo CJSON::encode($jsonResult);
                        Yii::app()->end();
                    }
		        }

		        $jsonResult = '{"result":true,"message":"The business has been added to your profile."}';
		        header('Content-Type: application/json');
		        echo CJSON::encode($jsonResult);
		        Yii::app()->end();

		    }
		}
		else
		{
		    $jsonResult = '{"result":false,"message":"No business id was supplied."}';
		    header('Content-Type: application/json');
		    echo CJSON::encode($jsonResult);
		    Yii::app()->end();

		}
	}

	/**
	 * Adds a business review by the logged in user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionReviewbusiness()
	{

	    $argBusinessId = (int) Yii::app()->request->getPost('review_business_id', null);
	    $argRating     = (int) Yii::app()->request->getPost('review_rating', null);
	    $argReview     = Yii::app()->request->getPost('review_text', null);

	    $userId = Yii::app()->user->id;

	    if ($userId === null)         // User is not known
	    {
	        $jsonResult = '{"result":false,"message":"This functionality is only avalable to logged in users."}';
	        header('Content-Type: application/json');
	        echo CJSON::encode($jsonResult);
	        Yii::app()->end();
	    }


	    if ($argBusinessId)
	    {
	        $modelBusiness = Business::model()->findByPk($argBusinessId);

	        if ($modelBusiness === null)
	        {
	            $jsonResult = '{"result":false,"message":"Something went wrong. The requested business could not be found."}';
	            header('Content-Type: application/json');
	            echo CJSON::encode($jsonResult);
	            Yii::app()->end();
	        }
	        else
	        {
	            // Add the business review to the user's profile. Update the
	            // ...review if the user has already reviewed the business, as a
	            // ...single review per business per user is allowed.

	            $modelBusinessReview = BusinessReview::model()->findByAttributes(array('user_id'=> Yii::app()->user->id, 'business_id' => $argBusinessId));
	            if ($modelBusinessReview === null)
	            {
	                $modelBusinessReview              = new Businessreview;
	                $modelBusinessReview->user_id         = $userId;
	                $modelBusinessReview->business_id     = $argBusinessId;
	            }


	            $modelBusinessReview->rating          = $argRating;
	            $modelBusinessReview->review_text     = filter_var($argReview, FILTER_SANITIZE_STRING);

	            if (!($modelBusinessReview->save()))
	            {
	                $jsonResult = '{"result":false,"message":"Something went wrong. The business review could not be saved."}';
	                header('Content-Type: application/json');
	                echo CJSON::encode($jsonResult);
	                Yii::app()->end();
	            }

// 	            $boolIsReviewed = BusinessReview::isReviewed(Yii::app()->user->id, $argBusinessId);

// 	            if ($boolIsReviewed === false)
// 	            {
// 	                $modelBusinessReview                  = new Businessreview;

// 	            }

	            $jsonResult = '{"result":true,"message":"The business review has been added to your profile."}';
	            header('Content-Type: application/json');
	            echo CJSON::encode($jsonResult);
	            Yii::app()->end();

	        }
	    }
	    else
	    {
	        $jsonResult = '{"result":false,"message":"No business id was supplied."}';
	        header('Content-Type: application/json');
	        echo CJSON::encode($jsonResult);
	        Yii::app()->end();

	    }
	}

	/**
	 * View the public profile of the user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionShow()
	{

	    $argUserId = (int) Yii::app()->request->getQuery('business_id', Yii::app()->user->id);

	    $userModel = User::model()->findByPk($argUserId);

	    // /////////////////////////////////////////////////////////////////////
	    // Get a list of the user's friends
	    // /////////////////////////////////////////////////////////////////////
	    $lstFriends = MyFriend::model()->with('friend')->findAllByAttributes(array(
	        'user_id' => $userModel->user_id, 'friend_status'=>'Approved'
	    ));

	    // /////////////////////////////////////////////////////////////////////
	    // Get a list of the user's images
	    // /////////////////////////////////////////////////////////////////////
	    $lstPhotos  = Photo::model()->findAllByAttributes(
	                       array('entity_id'   => $userModel->user_id,
	                             'photo_type'  => 'user'));

	    // /////////////////////////////////////////////////////////////////////
	    // Get a list of the user's events
	    // /////////////////////////////////////////////////////////////////////
	    $lstEvents = Event::model()->findAllByAttributes(array(
                	        'user_id' => $userModel->user_id,
                	    ));

	    // /////////////////////////////////////////////////////////////////////
	    // Get a list of the user's posts
	    // /////////////////////////////////////////////////////////////////////
	    $lstQuestions  = PostQuestion::model()->findAllByAttributes(array(
            	               'user_id' => $userModel->user_id, 'status'=>'Open'
            	         ));

	    $lstAnswers    = PostAnswer::model()->findAllByAttributes(array(
            	               'user_id' => $userModel->user_id, 'status'=>'Open'
            	         ));


        $this->render('user_public_profile', array(
                        'userModel'     => $userModel,
                        'lstFriends'    => $lstFriends,
                        'lstPhotos'     => $lstPhotos,
                        'lstEvents'     => $lstEvents,
                        'lstQuestions'  => $lstQuestions,
                        'lstAnswers'    => $lstAnswers,

               ));

	}

	/**
	 * Deletes an existing search record.lst
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
	public function actionRemovesearch()
	{

	    // TODO: add proper error message . iether flash or raiseerror. Might
	    // be difficult when sending ajax response.

	    if(Yii::app()->request->isPostRequest)
	    {

	        $searchId = $_POST['search_id'];
	        $searchModel = SavedSearch::model()->findByPk($searchId);

	        if ($searchModel == null)
	        {
	            Yii::app()->user->setFlash('warning','Saved search not found.');
	            echo CJSON::encode('{"result":"fail", "message":"Invalid search"}');
	            Yii::app()->end();
	        }


            $result = $searchModel->delete();

            if ($result == false)
            {
                Yii::app()->user->setFlash('warning','Failed to delete saved search.');
                echo CJSON::encode('{"result":"fail", "message":"Failed to mark record for deletion"}');
                Yii::app()->end();
            }

            Yii::app()->user->setFlash('success','Saved search deleted.');
            echo CJSON::encode('{"result":"success", "message":""}');
            Yii::app()->end();
        }
        else
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }


    }

    /**
     * Updates an existing saved search record.
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
    public function actionEditsearch()
    {

        $searchId = $_GET['id'];

        $searchModel = SavedSearch::model()->findByPk($searchId);
        if($searchModel===null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }


        // Uncomment the following line if AJAX validation is needed
        // TODO: Currently disabled as it breaks JQuery loading order
        // $this->performAjaxValidation($couponModel);

        if(isset($_POST['SavedSearch']))
        {
            // Assign all fields from the form
            $searchModel->attributes=$_POST['SavedSearch'];

            if($searchModel->save())
            {
                Yii::app()->user->setFlash('success', "Details saved.");
                $this->redirect(Yii::app()->request->urlReferrer);
            }
            else {
                Yii::app()->user->setFlash('error', "Error creating a coupon record.");
            }

        }


        // Show the details screen
        $this->renderPartial('search_update_modal', array('model'=>$searchModel));

    }

}