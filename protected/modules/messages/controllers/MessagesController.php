<?php

/**
 * Messages Controller interface for the Frontend (Public) Messagess Module
*/


/**
 * MessagesController is a class to provide access to controller actions for the
* ...user messages (front-end). The controller action interfaces directly' with
* ...the Client, and must therefore be responsible for input processing and
* ...response handling.
*
* Usage:
* ...Typical usage is from a web browser, by means of a URL
* ...
* ...   http://application.domain/index.php?/messages/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
* ...eg.
* ...   http://mydomain/index.php?/messages/profile/show/name/toms/
* ...
* ...The 'action' in the request is converted to invoke the actionAction() action
* ...eg. /messages/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
* ...(case is significant)
* ...Additional parameters after the action are passed as $_GET pairs
* ...eg. /messages/profile/show/name/toms/ will pass $_GET['name'] = 'toms'
*
* @package   Controllers
* @author    Pradesh <pradesh@datacraft.co.za>
* @copyright 2014 florida.com
* @package Controllers
* @version 1.0
*/


class MessagesController extends Controller
{

    public 	$layout='//layouts/front';

    /**
	 * @return array action filters
	 */
// 	public function filters()
// 	{
// 		return array(
// 			'accessControl', // perform access control for CRUD operations
// 		);
// 	}

    /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
// 	public function accessRules()
// 	{
//         return array(
// 			array('allow',
// 				'actions'=>array(),
// 				'expression'=>'Users::isAdmin()',
// 			),

//             array('deny',  // deny all users
//                 'users'=>array('*'),
//             ),
// 		);
// 	}

    /**
     * Default controller action.
     * Displays the messags lists
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {

        /*
         * Get the message summary details
        */

        $countMessagesByCategory = Yii::app()->db->createCommand()
                                             ->select('message_bucket, `read` AS read_status, COUNT(*) AS count')
                                             ->from('tbl_user_message')
                                             ->where('recipient = :user_id', array('user_id' => Yii::app()->user->id))
                                             ->group('message_bucket, read_status')
                                             ->queryAll();

        $summaryMessageCount                        = array();
        $summaryMessageCount['Inbox']['Y']          = 0;
        $summaryMessageCount['Inbox']['N']          = 0;
        $summaryMessageCount['Archive']['Y']        = 0;
        $summaryMessageCount['Archive']['N']        = 0;
        $summaryMessageCount['Pending Delete']['Y'] = 0;
        $summaryMessageCount['Pending Delete']['N'] = 0;

        foreach ($countMessagesByCategory as $countMessages)
        {
//              $messageCount = array();
            if (empty($countMessages['message_bucket']))
            {
                $countMessages['message_bucket'] = 'Inbox';
            }
            $summaryMessageCount[$countMessages['message_bucket']][$countMessages['read_status']] = $countMessages['count'];
            $summaryMessageCount[$countMessages['message_bucket']]['total'] =
                $summaryMessageCount[$countMessages['message_bucket']]['Y'] +
                $summaryMessageCount[$countMessages['message_bucket']]['N'];
        }
        $summaryMessageCount['Inbox']['total']          =  $summaryMessageCount['Inbox']['Y'] +
                                                           $summaryMessageCount['Inbox']['N'];

        $summaryMessageCount['Archive']['total']        =  $summaryMessageCount['Archive']['Y'] +
                                                           $summaryMessageCount['Archive']['N'];

        $summaryMessageCount['Pending Delete']['total'] =  $summaryMessageCount['Pending Delete']['Y'] +
                                                           $summaryMessageCount['Pending Delete']['N'];



        $lstMessages = UserMessage::model()->findAllByAttributes(array('recipient'=>Yii::app()->user->id));



        $this->render("messages_main", array('mainview' => 'mailbox_list',
                                             'data'     => array('myMessages'        => $lstMessages,
                                                                 'myMessagesSummary' => $summaryMessageCount)
                                                           )
                                       );

    }




    /**
     * Display the request message
     *
     * @param $message integer the requested message id
     *
     * @return <none> <none>
     * @access public
     */
	public function actionDetails($message)
	{

	    // Only allow logged in users to acces this function
	    if (Yii::app()->user->id === null)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

        $messageModel = UserMessage::model()->findByPk((int) $message);


        if (!$messageModel)
        {
            throw new CHttpException(404, 'Invalid request. Requested Message could not be found.');
            Yii::app()->end();
        }

        // Only allow users to request their own messages
        if ($messageModel->recipient != Yii::app()->user->id)
        {
            throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
        }

        $this->renderPartial("details",  array('data' => array('model'=>$messageModel)));
//         $this->render("messages_main", array('mainview'          => 'details',
//                                              'data'              => array(
//                                              'model'             => $messageModel,
//                                              'myMessagesSummary' => $this->getInboxSummary()
//                                        )));
        Yii::app()->end();

	}

	/**
	 * Process a request to reply to the current message. This actions is called
	 * ...twice - once to request the message and display the reply form, and
	 * ...once to post the reply.
	 *
	 * @param $message integer the requested message id
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionReply($message)
	{


	    // Only allow logged in users to acces this function
	    if (Yii::app()->user->id === null)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    $messageModel = UserMessage::model()->findByPk((int) $message);


	    if (!$messageModel)
	    {
	        throw new CHttpException(404, 'Invalid request. Requested Message could not be found.');
	        Yii::app()->end();
	    }

	    // Only allow users to request their own messages
	    if ($messageModel->recipient != Yii::app()->user->id)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    if (isset($_POST['UserMessage']))
	    {

	        $replyMessage = new UserMessage;
	        $replyMessage->attributes  = $_POST['UserMessage'];


	        $replyMessage->sender          = Yii::app()->user->id;
	        $replyMessage->recipient       = $messageModel->sender;
	        $replyMessage->reply_to        = $messageModel->id;

	        if ($replyMessage->validate())
	        {

	            if ($replyMessage->save())
	            {
	                Yii::app()->user->setFlash('success','Message Sent.');
	                $this->redirect(array('/messages/'));
	                Yii::app()->end();
	            }
	            else
	            {
	                Yii::app()->user->setFlash('warning','The message could not be sent at this time. Try again later. Contact the administrator if the problem persists.');
	                $this->redirect(array('/messages/'));
	                Yii::app()->end();
	            }

	        }

	    }

	    $messageModel->subject = 'Re: '.$messageModel->subject;
	    $messageModel->message = "\r\n\r\n>>> Original message >>>\r\n".$messageModel->message."\r\n\r\n>>>";

        $this->render("messages_main", array('mainview'          => 'reply',
                                             'data'              => array(
                                             'model'             => $messageModel,
                                             'myMessagesSummary' => $this->getInboxSummary()
                                            )));
	    Yii::app()->end();

	}

	/**
	 * Process a request a new message. This actions is called twice.
	 * ...- once to request the message and display the new mesage form, and
	 * ...- once to post the message.
	 *
	 * @param  <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{

	    // Only allow users to request their own messages
	    if (Yii::app()->user->id === null)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    $messageModel              = new UserMessage;

	    if (isset($_POST['UserMessage']))
	    {

	        $messageModel->attributes  = $_POST['UserMessage'];
	        $messageModel->sender      = Yii::app()->user->id;

	        if ($messageModel->validate())
	        {
	           if ($messageModel->save())
	           {
	               Yii::app()->user->setFlash('success','Message Sent.');
	               $this->redirect(array('/messages/'));
   	               Yii::app()->end();

	           }
	           else
	           {
	               Yii::app()->user->setFlash('warning','The message could not be sent at this time. Try again later. Contact the administrator if the problem persists.');
	               $this->redirect(array('/messages/'));
	               Yii::app()->end();
	           }

	        }

	    }

        $this->render("messages_main", array('mainview' => 'create',
                                             'data' => array(
                                                'model'             => $messageModel,
                                                'myMessagesSummary' => $this->getInboxSummary()
                                            )));
        Yii::app()->end();

	}

	/**
	 * Process a message delete request.
	 * ...We only process POST requests. The $_GET['message'] is ignored.
	 *
	 * @param $message integer the requested message id
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionDelete($message)
	{

	    // Only allow logged in users to acces this function
	    if (Yii::app()->user->id === null)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    if (!isset($_POST['message']))
	    {
	        throw new CHttpException(404, 'Not found. The requested page was not found.');
	    }

	    $messageId = (int) $_POST['message'];

	    $messageModel = UserMessage::model()->findByPk($messageId);


	    if (!$messageModel)
	    {
	        throw new CHttpException(404, 'Invalid request. Requested Message could not be found.');
	        Yii::app()->end();
	    }

	    // Only allow users to request their own messages
	    if ($messageModel->recipient != Yii::app()->user->id)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    $messageModel->delete();

	    Yii::app()->user->setFlash('success','Message deleted.');
	    echo CJSON::encode(array('result' => true, 'message' => 'Message deleted.'));

	}

	/**
	 * Calculates summary information for the current' user's inbox by category
	 *
	 * @param <none> <none>
	 *
	 * @return array the summary matrix
	 * @access private
	 */
	private function getInboxSummary()
	{

        /*
         * Get the message summary details
         */
        $countMessagesByCategory = Yii::app()->db->createCommand()
                                             ->select('message_bucket, `read` AS read_status, COUNT(*) AS count')
                                             ->from('tbl_user_message')
                                             ->where('recipient = :user_id',
                                                     array('user_id' => Yii::app()->user->id))
                                             ->group('message_bucket, read_status')
                                             ->queryAll();

        $summaryMessageCount = array();
        $summaryMessageCount['Inbox']['Y'] = 0;
        $summaryMessageCount['Inbox']['N'] = 0;
        $summaryMessageCount['Archive']['Y'] = 0;
        $summaryMessageCount['Archive']['N'] = 0;
        $summaryMessageCount['Pending Delete']['Y'] = 0;
        $summaryMessageCount['Pending Delete']['N'] = 0;

        foreach ($countMessagesByCategory as $countMessages) {
            // $messageCount = array();
            if (empty($countMessages['message_bucket'])) {
                $countMessages['message_bucket'] = 'Inbox';
            }
            $summaryMessageCount[$countMessages['message_bucket']][$countMessages['read_status']] = $countMessages['count'];
            $summaryMessageCount[$countMessages['message_bucket']]['total'] = $summaryMessageCount[$countMessages['message_bucket']]['Y'] + $summaryMessageCount[$countMessages['message_bucket']]['N'];
        }
        $summaryMessageCount['Inbox']['total'] = $summaryMessageCount['Inbox']['Y'] + $summaryMessageCount['Inbox']['N'];

        $summaryMessageCount['Archive']['total'] = $summaryMessageCount['Archive']['Y'] + $summaryMessageCount['Archive']['N'];

        $summaryMessageCount['Pending Delete']['total'] = $summaryMessageCount['Pending Delete']['Y'] + $summaryMessageCount['Pending Delete']['N'];

        return $summaryMessageCount;

	}
}