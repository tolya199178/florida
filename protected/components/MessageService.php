<?php


/**
 * Helper class for Message Service facility
 */


/**
 * MessageService is a class containing functions to provide a meesage facility
 * ...to users through the internal message mechanism, which makes it possible
 * ...for users to send messages to each other.
 *
 * Usage:
 * ...Typical usage is from othe application componente (eg, model, or controller)
 * ...
 * ...   MessageService::helperFunction(arguments ...)
 * ...eg.
 * ...   MessageService::sendMessage('1234567890');
 * ...
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class MessageService
{

    /**
     * Sends a message.
     *
     * @param $toAddress string The recpient ID reference
     * @param $msgSubject string The message subject
     * @param $msgContent string The message to be sent
     *
     * @return boolean result of send.
     * @access public
     */
    public static function sendMessage($toAddress, $msgSubject = null, $msgContent = null)
    {

        /**
         * We can't do anything if :-
         * - A recipient is not supplied
         * - A message to be sent is not supplied
         */

        if (empty($toAddress) || empty($msgContent))
        {
            return false;
        }

        /*
         * Validate the recipient id, and check that the record is pointing to a true friend,
         * ...and that the sender is not blocked.
        */
        $recipientModel = MyFriend::model()->findByAttributes(array('user_id'=> Yii::app()->user->id,
                                                                    'friend_id'=>(int) $toAddress));

        if ($recipientModel && ($recipientModel->friend_status == 'Approved'))
        {

            $messageModel               = new UserMessage;

            $messageModel->recipient    = (int) $toAddress;
            $messageModel->sender       = Yii::app()->user->id;
            $messageModel->subject      = $msgSubject;
            $messageModel->message      = $msgContent;

            return ($messageModel->save());
        }
        else
        {
            Yii::app()->user->setFlash('error','You cannot send messages to this user.');
            return false;
        }


    }

}