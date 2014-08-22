<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
			'db'=>array(
					'connectionString' => 'mysql:host=localhost;dbname=florida_dev',
					'emulatePrepare' => true,
					'username' => 'root',
					'password' => 'bluebell',
					'charset' => 'utf8',
			        	'tablePrefix' => 'tbl_',
					'enableParamLogging' => true,
			),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'info, vardump',
                    'logFile'=>'console_info',
                    'maxLogFiles'=>10
                ),
//                array(
//                    'class'=>'CFileLogRoute',
//                    'levels'=>'trace',
//                    'logFile'=>'console_info',
//                    'maxLogFiles'=>10,
//                    'categories'=>'system.db.CDbCommand'
//                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'trace, error, warning',
                ),
            ),
        ),

	),
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.ticket-network.*',
        'application.extensions.ticket-network.src.Exception.*',
        'application.extensions.Thumbnail',
    ),
);
