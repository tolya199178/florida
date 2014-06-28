<?php


/**
 * Helper class for ShortMessage Service facility
 */


/**
 * ShortMessageService is a class containing functions to provide a SMS facility
 * ...to users through a list of predefined mobile carriers. The facility uses
 * ...the email-to-sms feature if it is supported by the mobile carrier.
 *
 * Usage:
 * ...Typical usage is from othe application componente (eg, model, or controller)
 * ...
 * ...   ShortMessageService::helperFunction(arguments ...)
 * ...eg.
 * ...   ShortMessageService::sendMessage('1234567890');
 * ...
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class ShortMessageService
{

    /**
     * Sends an SMS message.
     *
     * The repicient name is doctored to comply with the template required by
     * ...the carrier. The carrier recipient is listed as a template value with
     * ...the tag field {numbers} specifying placement of the actual number.
     * ...For example : {number}@mymobilecarrier.com
     *
     * @param $toAddress string The recpient SMS address
     * @param $toCarrier int The mobile carrier ID
     * @param $msgSubject string The message subject
     * @param $msgContent string The message to be sent
     *
     * @return boolean result of send.
     * @access public
     */
    public static function sendMessage($toAddress, $toCarrier = null, $msgSubject = null, $msgContent = null)
    {

        /**
         * We can't do anything if :-
         * - the mobile carrier has not been supplied.
         * - A recipient is not supplied
         * - A message to send is not supplied
         */
        if ($toCarrier === null)
        {
            return false;
        }
        if (empty($toAddress) || empty($msgContent))
        {
            return false;
        }

        // /////////////////////////////////////////////////////////////////////
        // Fetch the mobile carrier details
        // /////////////////////////////////////////////////////////////////////
        $modelMobileCarrier = MobileCarrier::model()->findByPk((int) $toCarrier);

        /**
         * We can't do anything if the mobile carrier is not found.
         */
        if ($modelMobileCarrier === null)
        {
            return false;
        }

        /**
         * Do not processes blocked carriers
         */
        if ($modelMobileCarrier->can_send == 'N')
        {
            return false;
        }

        /*
         * Reformat the sender
         */
        $toEmailAddress = str_replace('{number}', $toAddress, $modelMobileCarrier->recipient_address);

        if (empty($toEmailAddress))
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
				'Content-type: text/plain; charset=iso-8859-1'
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


}