<?php

/**
 * Profile Controller interface for the Frontend (Public) Business Module
 */


/**
 * ProfileController is a class to provide access to controller actions for general
 * ..processing of business profile actions. The contriller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/business/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/business/profile/show/name/toms-diner/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /business/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /business/profile/show/name/toms-diner/ will pass $_GET['name'] = 'toms-diner'
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
     * Displays the profile for the given Business id
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionShow()
	{

		$argBusinessId = (int) Yii::app()->request->getQuery('id', null);

		if ($argBusinessId)
		{
		    $modelBusiness = Business::model()->findByPk($argBusinessId);

		    if ($modelBusiness === null)
		    {
		        throw new CHttpException(404,'No such user. The requested user page does not exist.');
		    }
		    else
		    {
		        // Get photos
		        // TODO: We should look into implementing this woth relations.
		        $listPhotos = Photo::model()->findAllByAttributes(array('entity_id' => $argBusinessId, 'photo_type' => 'business'));


        		$this->renderPartial('profile_modal', array('model'=>$modelBusiness, 'photos' => $listPhotos));
		    }
		}
		else
		{
		    throw new CHttpException(404,'No user supplied. The requested user page does not exist.');
		}
	}
}