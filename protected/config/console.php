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
					'connectionString' => 'mysql:host=localhost;dbname=florida',
					'emulatePrepare' => true,
					'username' => 'root',
					'password' => 'bluebell',
					'charset' => 'utf8',
					'enableParamLogging' => true,
			),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),

	),
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
);