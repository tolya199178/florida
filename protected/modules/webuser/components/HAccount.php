<?php


class HAccount
{
    
    /* Create a random verify code */
    public function getVerificationCode($toEmailAddress)
    {
        
		$encodedEmailAddress      = urlencode($toEmailAddress);
		$specialString 			  = 'datacraft?'.time();
		$verificationCode         = md5($encodedEmailAddress.$specialString);
		
		return $verificationCode;

    }
    
    /* Create a random verify code */
    public function sendMessage($toEmailAddress = null, $toName = null, $msgSubject, $msgContent)
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
    
    /* Replace {varname} with $replacementValuesList['varname'] */
    public function CustomiseMessage($messageContent, $replacementValuesList)
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
    
    public function getEmailMessage($messageName)
    {
        // /////////////////////////////////////////////////////////////////////
        // Get the message details
        // /////////////////////////////////////////////////////////////////////
        $modelMailTemplate    = MailTemplate::model()->findByAttributes(array('template_name' =>$messageName));
        if ($modelMailTemplate === null)
        {
            return null;
        }
        
        $messageContent       = $modelMailTemplate->attributes['msg'];
        
        return $messageContent;

    }
    
    
}