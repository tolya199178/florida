<?php
/**
 * Message Controller
 */
class MessageController extends Controller
{
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
     * Index action - displays the home page
     */

	public function actionDetails($message) {
        $messageModel = UserMessage::model()->findByPk($message);


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

        $this->renderPartial("details",  array('model' => $messageModel));

	}

	public function actionReply($message) {


	    // Only allow logged in users to acces this function
	    if (Yii::app()->user->id === null)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    $messageModel = UserMessage::model()->findByPk($message);


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
	                echo CJSON::encode(array('result' => true, 'message' => 'Message sent.'));
	                Yii::app()->end();
	            }
	            else
	            {
	                $msg = 'The message could not be sent at this time. Try again later. Contact the administrator if the problem persists.';
	                echo CJSON::encode(array('result' => false, 'message' => $msg));
	                Yii::app()->end();
	            }

	        }

	    }

	    $messageModel->subject = 'Re: '.$messageModel->subject;
	    $messageModel->message = "\r\n\r\n>>> Original message >>>\r\n".$messageModel->message."\r\n\r\n>>>";

	    $this->renderPartial("reply",  array('model' => $messageModel));

	    Yii::app()->end();

	}

	public function actionCreate() {

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
	               echo CJSON::encode(array('result' => true, 'message' => 'Message sent'));
	               Yii::app()->end();
	           }
	           else
	           {
	               $msg = 'The message could not be sent at this time. Try again later. Contact the administrator if the problem persists.';
	               echo CJSON::encode(array('result' => false, 'message' => $msg));
   	               Yii::app()->end();
	           }

	        }

	    }

        $this->renderPartial("create",  array('model' => $messageModel));

	}

	public function actionDelete($message) {

	    // Only allow logged in users to acces this function
	    if (Yii::app()->user->id === null)
	    {
	        throw new CHttpException(400, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

	    if (!isset($_POST['id']))
	    {
	        throw new CHttpException(404, 'Not found. The requested page was not found.');
	    }

	    $messageId = (int) $_POST['id'];

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


	    echo CJSON::encode(array('result' => true, 'message' => 'Message deleted.'));

	}
}