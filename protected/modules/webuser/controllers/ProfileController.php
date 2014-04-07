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
}