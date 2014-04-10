<?php

// Include our files
include_once ('FBToolbox.class.php');

// Prepare the object
$fbToolboxObj = new FBToolbox('YOUR_API_KEY', 'YOUR_SECRET_KEY');


// Get user information
$userInfo = $fbToolboxObj->getUserInfo('FB USER ID');
//print_r($userInfo);
echo $userInfo[0]['current_location']['city'];

// Get friend list here
$friendList = $fbToolboxObj->getFriendList('FB USER ID',false,0,20);
//print_r($friendList);

// Send notification
$fbToolboxObj->sendNotification(array('FB USER ID'),'test api class','app_to_user');

// Send email notification (CAUTION: your application must have permission from user)

$fbToolboxObj->sendEmail('FB USER ID','test api class','test api class');

// Publish news feed


$one_line_story_templates[] = '{*actor*} has developed a php wrapper
class for facebook application developer.';
//You have to run this function only one times to get template bundle id
$templateBundleId = $fbToolboxObj->getTemplateBundleId($one_line_story_templates);

$fbToolboxObj->publishNewsFeed('FB USER ID',$templateBundleId);

// Add your application to your profile
$fbToolboxObj->addToProfile('FB USER ID',"Wider FbMl","narrow fbml");
?>

<!-- you have to print this line to add application to user profile
if user click on addtoprofile link then above function will work -->
<div