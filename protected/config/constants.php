<?php

// NOTE: Maybe I won't use this method
// NOTE: Maybe I won't use this method
// NOTE: Maybe I won't use this method

/**
 * constants file.
 *
 * @author pradesg
 * @link http://www.florida.com
 * @copyright Copyright (c) 2014, florida.com
 * 
 * @package application.config 
 * @version 1.0
 * 
 * Global application wide parameters wrapper. All parameters are defined in the
 * ...//config/parameters.php file. This function (included in main.php) transforms
 * ...each one from array elements to a defined constant
 * ...
 * ...Usage of the defined constant is as for a normal defined constant. e.g.
 * ---echo SITE_NAME;
 * 
 */

//For using register all parm key and value to be constant
$params = include('params.php' );

foreach ($params as $key => $value) {
    define($key, $value);
} 
