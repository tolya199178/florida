<?php

/**
 * Application-wide constants.
 *
 * @author pradesg
 * @link http://www.florida.com
 * @copyright Copyright (c) 2014, florida.com
 *
 * @package application.config
 * @version 1.0
 *
 * Global application wide parameters. All parameters transformed by the constants.php wrapper
 * ---from array elements to a defined constant
 * ...
 * ...Usage of the defined constant is as for a normal defined constant. e.g.
 * ---echo SITE_NAME;
 * OR
 * ...echo Yii::app()->params['paramName'];
 *
 */


return array(
    
    // -------------------------------------------------------------------------
    // Site identifier
    // -------------------------------------------------------------------------
    'SITE_NAME' => 'Florida.com',
    

    // -------------------------------------------------------------------------
    // Locale Settings
    // -------------------------------------------------------------------------
    'STATE'             => 'Florida',
    'COUNTRY'           => 'United States of America',
    'CURRENCY_CODE'     => 'USD',
    'CURRENCY_SYMBOL'   => '$',
    'DATE_FORMAT'       => 'MM-DD-YYYY',
    
    

    // -------------------------------------------------------------------------
    // Email settings
    // -------------------------------------------------------------------------
    //Email Config
    'SITE_MAIL_UNAME'       => 'kamatchi.pandian@optisolbusiness.com',
    'SITE_MAIL_PWD'         => 'jkp7707',
    'SITE_SMTPHOST'         => 'secure.emailsrvr.com',
    'SITE_SMTPPORT'         => '465', // Port: 465 or 587 
    'MAILSENDBY'            => 1, //if 1 send by phpmailer function || if 2 send by SMTP  || if 3 dont send the mail
    
    'EMAIL_TEMPLATE_PATH'   => 'mailtemplates/',
    'EMAILHEADERIMAGE'      => '',
    'SITE_FROMEMAIL'        => 'noreply@Florida.com',
    'SITE_FROMNAME'         => 'Florida.com',
    'SITE_INFOEMAIL'        => 'info@Florida.com',
    'SITE_SUPPORTEMAIL'     => 'support@Florida.com',
    'SITE_AlERTMAIL'        => 'alert@Florida.com',
    
    
    // -------------------------------------------------------------------------
    // Facebook application API details
    // -------------------------------------------------------------------------
    'SITE_FB_URL'       => 'https://www.facebook.com/floridasandbox',
    'FB_APPID'          =>'580601078622835',//479986035449690
    
    // -------------------------------------------------------------------------
    // Twitter API details
    // -------------------------------------------------------------------------
    'SITE_TW_URL'       => 'https://twitter.com/',
    // TODO: Account settings ?
    

    
    // -------------------------------------------------------------------------
    // PayPal API details
    // -------------------------------------------------------------------------
    //Paypal
    'PAYPALURL' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
    //'PAYPALURL' => 'https://www.paypal.com/cgi-bin/webscr',
    'PAYPALBUSINESSEMAIL' => 'jkp.ph_1359131919_biz@gmail.com',
    'PAYPALCURRENCYCODE' => 'USD',
    // TODO: Account settings ? Merchant account
    

    // -------------------------------------------------------------------------
    // Priceline details
    // -------------------------------------------------------------------------
    //Priceline Api Details
    'PL_DEFAULT_CITY' => "3000003311",
    'PL_REFER_ID' => "3991",
    'PL_MIN_DISP' => "10",
    'PL_RESULT' => "10",
    'PL_API_URL' => 'http://api.rezserver.com/widgets/getHotelDeals',


    // -------------------------------------------------------------------------
    // Misc
    // -------------------------------------------------------------------------

    
    'PAGESIZEREC' => 20,
    
    //'SITE_GPLUS_URL' => 'https://plus.google.com/u/0/+',
    'SEC_SIG' => "flo{rida$@#obs%^@~~",
    
    'SITE_PHNO' => '000-000-0000',
    'LOGO_PATH' => "http://sandbox.florida.com/assets2/img/logo-v1.png",
    'PROF_IMG_PATH' => "profile_image/",
    'BUSINESS_IMG_PATH' => "BusinessImage/",
    //For login user set cookie
    'COOKIE_NAME' => 'florida_user',
    'COOKIE_PWD' => 'florida_pwd',

    

    //Ticket Net work
    'SITE_IP' => '209.208.92.70',
    'BROKERID' => '1447',
    'SITENO' => '6',
    'SITECONFIG' => '11150',

    //Getyourguide
    'GG_CATEGORYLIST' => 'https://api.getyourguide.com/?partner_id=5073458F48&language=en&q=category_list',
    'GG_DESTINATIONLIST' => 'https://api.getyourguide.com/?partner_id=5073458F48&language=en&q=destination_list',
    'GG_API_CONTENTS' => 'https://api.getyourguide.com/?partner_id=5073458F48&language=en&q=product_list&where=florida',

    //TicketNetwork
    'TN_URL' => "https://tickettransaction2.com/Checkout.aspx?brokerid={brokerid}&sitenumber={sitenumber}&tgid={tgid}&treq=1&evtID={evtID}&price={price}&SessionId={SessionId}",
    'WSDL' => "http://tnwebservices.ticketnetwork.com/tnwebservice/v3.2/TNWebServiceStringInputs.asmx?WSDL",
    
    
    //Version
    'VERSION' => '1.0',
    'SYSTEM_USER' =>'careers,support'
);
