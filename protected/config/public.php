<?php
return CMap::mergeArray(
		require(dirname(__FILE__).'/main.php'),
		array(
				'components'	=> array(
// TODO: Disabled for now. Will address later
// 						'urlManager' => array(
// 								'urlFormat' => 'path',
// 								'showScriptName' => false,
// 								'rules' => array(
// 										'<controller:\w+>/<id:\d+>' => '<controller>/view',
// 										'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
// 										'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
// 								),
// 						),
// TODO: END
				    
				)
				// NOTE: Put additional front-end settings there. Don't forget the comma
		)
);
?>