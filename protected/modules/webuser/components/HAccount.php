<?php 
 
/**
 * User Account helper 
 */


/**
 * The User Account helper class contains a collection of functions thar
 * ...provide supporting functionality to the managemenr of user accounts.
 *
 * Usage:
 * ...Typical usage is from another module
 * ...
 * ...   HAccount::Function(args...)
 * ...eg.
 * ...   HAccount::GenerateOneTimePassword($loginName)
 * ...
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class HAccount extends CApplicationComponent
{
    
    public function generateActivationCode($toEmailAddress) {
        
        $encodedEmail 			   = urlencode($toEmailAddress);
        $specialString 			   = 'florida?'.time();
        $hashString                = md5($encodedEmail.$specialString);
        
        return $hashString;
    }
    
    public function sendValidationMessage($validationCode, $emailToAddress, $emailToName = null)
    {
        
        // Don't go any further without a validation code or email address.
        if (empty($validationCode) || empty($emailToAddress))
        {
            return false;
        }
        

        $emailFromAddress       = Yii::app()->params['SITE_FROMNAME'].' <'.Yii::app()->params['SITE_FROMEMAIL'].'>';
        
        if ($emailToName)
        {
            $emailToAddress     = $emailToName.' <'.$emailToAddrress.'>';
        }
        else
        {
            $emailToAddress     = $emailToAddrress;
        }
        
        
        
        $emailHeaders = array(
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=iso-8859-1'
        );
        
        
        
        // Send validation email
        if ($area == 'online_strategy') {
            $message				=  $this->renderPartial('programme/online_strategy/welcome_email',$data, true);
            $subject				= 'Thank you for registering for the Online Strategy programme';
            $welcome_page			= 'programme/online_strategy/welcome';
        }
        else {
            $message				=  $this->renderPartial('register/welcome_email',$data, true);
            $subject				= 'Thank you for your subscription';
            $welcome_page			= 'register/welcome';
        }
        
        
        
        // echo $message;
        
        Yii::app()->email->send($from_email_adddress, $to_email_address, $subject, $message, $headers);
        // Send 'CC'
        Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: '.$subject, $message, $headers);
        
    }
    
}