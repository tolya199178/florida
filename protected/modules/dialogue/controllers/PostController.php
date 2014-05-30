<?php

/**
 * Post Controller interface for the Frontend (Public) Dialogue Module
 */


/**
 * PostController is a class to provide access to controller actions for general
 * ..processing of user friends actions. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/dialogue/post/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/dialogue/show/comment/134/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /dialogue/show/comment/134/ will invoke PostController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /dialogue/show/comment/134/ will pass $_GET['comment'] = '134'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class PostController extends Controller
{

    /**
     * Default controller action.
     * Shows the listing of friends
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{


	}


}