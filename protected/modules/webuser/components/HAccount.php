<?php


/**
 * Helper class for Account Management
 */


/**
 * HAccount is a class containing functions to support the account management
 * ...on the site (mostly front end).to provide access to controller actions for general
 *
 * Usage:
 * ...Typical usage is from othe application componente (eg, model, or controller)
 * ...
 * ...   HAccount::helperFunction(arguments ...)
 * ...eg.
 * ...   HAccount::getVerificationCode('myemail@mydomain.com');
 * ...
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class HAccount
{


    /**
     * Create a random verify code to be used for account validation. Use the email
     * ...address as a salt.
     *
     * @param $toEmailAddress string The value to use for generating the code
     *
     * @return string the activation code
     * @access public
     */
    public static function getVerificationCode($toEmailAddress)
    {

		$encodedEmailAddress      = urlencode($toEmailAddress);
		$specialString 			  = 'datacraft?'.time();
		$verificationCode         = md5($encodedEmailAddress.$specialString);

		return $verificationCode;

    }

    /**
     * Sends an email message.
     *
     * @param $toEmailAddress string The recpient email address
     * @param $toName string The recpient name
     * @param $msgSubject string The message subject
     * @param $msgContent string The message to be sent
     *
     * @return <none>
     * @access public
     */
    public static function sendMessage($toEmailAddress = null, $toName = null, $msgSubject, $msgContent)
    {

        if (empty($toEmailAddress) || empty($toName))
        {
            return false;
        }

		$fromEmailAdddress  	=  Yii::app()->params['SITE_FROMNAME'].' <'.Yii::app()->params['SITE_FROMEMAIL'].'>';

		if (!empty($toName))
		{
		    $toEmailAddress       = $toName.' <'.$toEmailAddress.'>';
		}

		$messageHeaders = array(
				'MIME-Version: 1.0',
				'Content-type: text/html; charset=iso-8859-1'
		);


		Yii::app()->email->send($fromEmailAdddress, $toEmailAddress, $msgSubject, $msgContent, $messageHeaders);


    }

    /*
    /**
     * Utility function to substitute values in a template.
     *
     * ...Template variables are enclosed with braces. For example :-
     * ...  'Hello. {your_name}. How are you today?'
     * ...The replacement values is an associative array with the replacement
     * ...key as the index key. For example.
     * ... $replacement_value['your_name'} = 'Tom'
     * ...The resulting string is
     * ...  'Hello. Tom. How are you today?'
     *
     * @param $messageContent string The template to be converted
     * @param $replacementValuesList array Associative list of replacement values
     *
     * @return string The template, after applying replacement
     * @access public
     */
    public static function CustomiseMessage($messageContent, $replacementValuesList)
    {

        $tagPersonalisation 		= array();
        $valuePersonalisation 		= array();

        if (preg_match_all("/{(.*?)}/", $messageContent, $m)) {

            foreach ($m[1] as $i => $varname) {
                $tagPersonalisation[]   = $m[0][$i];
                $valuePersonalisation[] = $replacementValuesList[$varname];
            }
        }

        $convertedMessage = str_replace($tagPersonalisation, $valuePersonalisation, $messageContent);

        return $convertedMessage;
    }


    /**
     * Retrieves the message from a given Email template.
     *
     * @param $messageName string The name of the message
     *
     * @return string The message content,
     * @access public
     */
    public static function getEmailMessage($messageName)
    {
        // /////////////////////////////////////////////////////////////////////
        // Get the message details
        // /////////////////////////////////////////////////////////////////////
        $modelMailTemplate    = MailTemplate::model()->findByAttributes(array('template_name' =>$messageName));
        if ($modelMailTemplate === null)
        {
            return null;
        }

        $messageContent       = CHtml::encode($modelMailTemplate->attributes['msg']);

        return $messageContent;

    }

    /**
     * Retrieves the message subject from a given Email template.
     *
     * @param $messageName string The name of the message
     *
     * @return string The message subject,
     * @access public
     */
    public static function getEmailSubject($messageName)
    {
        // /////////////////////////////////////////////////////////////////////
        // Get the message details
        // /////////////////////////////////////////////////////////////////////
        $modelMailTemplate    = MailTemplate::model()->findByAttributes(array('template_name' =>$messageName));
        if ($modelMailTemplate === null)
        {
            return null;
        }

        $messageSubject       = CHtml::encode($modelMailTemplate->attributes['subject']);

        return $messageSubject;

    }


}