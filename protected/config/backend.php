<?php
return CMap::mergeArray(
        require (dirname(__FILE__) . '/main.php'),
        array(
            'components' => array(
// TODO: Disabled for now. Will address later
//         'user'=>array(
//             // enable cookie-based authentication
//             'allowAutoLogin'=>true,
//             'loginUrl' => array('/backend/site/login'),
//             'class'=>'WebUser',
//         ),
//
//         'urlManager' => array(
//             'urlFormat' => 'path',
//             'showScriptName' => false,
//             'rules' => array(
//                 // default backend url
//                 'backend' => 'site/index',
//                
//                 // User admin
//                 'backend'           => 'site/index',
//                 'backend/user'      => 'site/',
//                
//                 // fallback
//                 'backend/<_c>' => '<_c>',
//                 'backend/<_c>/<_a>' => '<_c>/<_a>'
//             )
//         )
// TODO: END
            )
            // NOTE: Put additional front-end settings there. Don't forget the comma
));
?>