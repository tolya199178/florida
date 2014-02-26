<?php
return CMap::mergeArray(
		require(dirname(__FILE__) . '/main.php'), array(
				// 'theme' 		=> 'renewal',
				'components' 	=> array(
						
// 						 'urlManager' => array(
// 						 		'urlFormat' => 'path',
// 						 		'showScriptName' => false,
// 						 		'rules' => array(
// 						 				'backend' => 'admin/login',
// 						 				'backend/<_c>' => '<_c>',
// 						 				'backend/<_c>/<_a>' => '<_c>/<_a>',
// 						 		),
// 						 ),
				)
		)
);
?>