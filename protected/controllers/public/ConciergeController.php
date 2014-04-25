<?php

/**
 * Controller interface for the Frontend (Public) Site Module
 */


/**
 * ConciergeController Controller class to provide access to controller actions for general
 * ...rendering of site. The contriller action interfaces 'directly' with the
 * ...Client, and must therefore be responsible for input processing and
 * ...response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/user/site/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/site/login/my_name/tom/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /site/login/my_name/tom/ will invoke UserController::actionLogin()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /site/login/my_name/tom/ will pass $_GET['my_name'] = tom
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

Yii::import("application.modules.webuser.components.HAccount");

class ConciergeController extends Controller
{

    /**
     * Override layout page.
     *
     * @return string $layout the location of the layout page.
     *
     */
	public 	$layout='//layouts/page';

    /**
     * Specify class-based actions. Specifies external (files or other classes
     * ...for action handlers. This allows the controller to redirect the action
     * ...another class for handing,
     *
     * @param <none> <none>
     *
     * @return array action specifiers
     * @access public
     */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

    /**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by users.
     *
     * Loads the concierge page.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$this->render('concierge');
	}

    /**
     * Generates a JSON encoded list of all citys.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionPrefecthlistall() {



        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        $cityList          = City::model()->findAll($searchCriteria);

//         if ($cityList){
//             header('Content-type: application/json');
//             echo CJSON::encode($cityList);
//         }



         $listResults = array();

         foreach($cityList as $recCity){
             $listResults[] = array('city_name' => $recCity->attributes['city_name']);
         }
          header('Content-type: application/json');

         echo CJSON::encode($listResults);



    }

    /**
     * Fires off a search and returns all results to the client.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionDosearch()
    {


        $argDoWhat      = Yii::app()->request->getPost('dowhat', null);
        $argWithWhat    = Yii::app()->request->getPost('withwhat', null);
        $argWhere       = Yii::app()->request->getPost('where', null);

        // /////////////////////////////////////////////////////////////////////
        // If a place was entered, find the corresponding city id.
        // /////////////////////////////////////////////////////////////////////
        $cityId = 0;
        if (!empty($argWhere))
        {
            $modelCity  = City::model()->find(array('condition'=>'city_name=:city_name','params'=>array(':city_name' => $argWhere)));

            if ($modelCity != null)
            {
                $cityId = $modelCity->attributes['city_id'];
            }
        }

        // /////////////////////////////////////////////////////////////////////
        // We start  building the query for the search. The three important
        // ...filters are :-
        // ... - the city
        // ... - the activity
        // ... - the activity type
        // ...The filters are not mandatory and all or at least one of the search
        // ...filters may be supplied.
        // /////////////////////////////////////////////////////////////////////
        $seachCriteria = new CDbCriteria;

        $seachCriteria->limit = Yii::app()->params['PAGESIZEREC+'];

        // /////////////////////////////////////////////////////////////////////
        // A business is linked to business_activities which in turn is linked
        // ...to activities and activity types.
        // ...Activity types is actually a child or Activity, from a MDM view.
        // ...However, for the performance purposes, the system records both
        // ...Activity and Activity Type against the Business Activity
        // ...So, operationally (used for classification)
        // ...  Business -> Business Activity
        // ...           -> Business Activity -> Activity
        // ...           -> Business Activity -> Activity Types
        // ...and from a model
        // ...  Actvity -> Activity type
        // /////////////////////////////////////////////////////////////////////
        $seachCriteria->with = array('businessActivities',
                                     'businessActivities.activity',
                                     'businessActivities.activityType',
                                    );

        $seachCriteria->together = true;

        // /////////////////////////////////////////////////////////////////////
        // Restrict the search to a specific city, if a city filter is supplied.
        // /////////////////////////////////////////////////////////////////////
        if (!empty($cityId))
        {
            $seachCriteria->compare('business_city_id', $cityId);
        }

        // /////////////////////////////////////////////////////////////////////
        // Build the WHERE clause for the activity filter. The activity table is
        // ...searched by matching the keyword and related word sets to the
        // ...activity keyword filter
        // /////////////////////////////////////////////////////////////////////
        if (!empty($argDoWhat))
        {
            $seachCriteria->addCondition( "FIND_IN_SET(:keyword_tag,`activity`.keyword) OR
                                           FIND_IN_SET(:related_word_tag,`activity`.related_words)"
                                        );
            $seachCriteria->params       = array_merge($seachCriteria->params, array(':keyword_tag'=>$argDoWhat, ':related_word_tag'=>$argDoWhat));
        }

        // /////////////////////////////////////////////////////////////////////
        // Build the WHERE clause for the activity type filter. The activitytype
        // ...table is searched by matching the keyword and related word sets
        // ...to the activity keyword filter
        // /////////////////////////////////////////////////////////////////////
        if (!empty($argWithWhat))
        {
            $seachCriteria->addCondition( "FIND_IN_SET(:keyword_tag,`activityType`.keyword) OR
                                           FIND_IN_SET(:related_word_tag,`activityType`.related_words)"
            );
            $seachCriteria->params       = array_merge($seachCriteria->params, array(':keyword_tag'=>$argWithWhat, ':related_word_tag'=>$argWithWhat));
        }

        // /////////////////////////////////////////////////////////////////////
        // Submit the query
        // /////////////////////////////////////////////////////////////////////
        $dataProvider = new CActiveDataProvider('Business',
            array(
                'criteria'  => $seachCriteria,
            )
        );

        // /////////////////////////////////////////////////////////////////////
        // Log the search summary
        // /////////////////////////////////////////////////////////////////////
        $this->logSearch($argDoWhat, $argWithWhat, $argWhere);


        $this->renderPartial('search_results_container',array('dataProvider'=>$dataProvider));

    }

    /**
     * Generates a JSON encoded list of all citys.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionLoadpanel()
    {
        $reqPanel   = Yii::app()->request->getQuery("panel");
        $reqPanel   = filter_var($reqPanel,FILTER_SANITIZE_STRING);

        switch ($reqPanel)
        {
        	case 'left':
        	    $this->loadLeftPanel();
        	    break;
        	case 'right':
        	    break;
    	    default:
	            break;
        }


    }

    /**
     * Loads HTML feed for rendering in the left panel.
     * ...-for not logged in users, anonymous actvity is displayed
     * ...-for logged in users, initial load shows friends
     * ...-for logged in users, after search load shows similar searches
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access private
     */
    private function loadLeftPanel()
    {

        // /////////////////////////////////////////////////////////////////////
        // For non logged in users, show anonymous activity
        // For logged in users, show user details
        // /////////////////////////////////////////////////////////////////////
        $lastTimestamp = Yii::app()->request->getQuery("last_timestamp");

        $dbCriteria = new CDbCriteria;
        // TODO: Move the search limit to parameters file
        $dbCriteria->condition = " unix_timestamp(created_time) > :lastTimestamp ";
        $dbCriteria->params    = array(':lastTimestamp' => $lastTimestamp);
        $dbCriteria->limit     = 100;
        $dbCriteria->order     = 'created_time DESC';

        $lstSearchLog = SearchHistory::model()->findAll($dbCriteria);

        $this->renderPartial("left_panel_feed_activity", array('model' => $lstSearchLog));
        Yii::app()->end();

    }

    /**
     * Fires off a search and returns all results to the client.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionGallery()
    {

        $argCityName  = Yii::app()->request->getPost('city', null);

        // /////////////////////////////////////////////////////////////////////
        //  Find city record from city name
        // /////////////////////////////////////////////////////////////////////
        if ($argCityName != null)
        {
            $cityModel = City::model()->findByAttributes(array('city_name' => $argCityName));
            if ($cityModel != null)
            {
                $cityId = $cityModel->city_id;

                // /////////////////////////////////////////////////////////////
                // Get all photos for the city
                // /////////////////////////////////////////////////////////////
                $lstCityPhotos  = Photo::model()->findAllByAttributes(array('entity_id' => $cityId, 'photo_type' => 'city'));
                if (count($lstCityPhotos) >0)
                {
                    $this->renderPartial('city_gallery', array('lstCityPhotos'=> $lstCityPhotos));
                }

                Yii::app()->end();

            }

        }

    }

    /**
     * Logs the search.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    private function logSearch($argDoWhat, $argWithWhat, $argWhere)
    {

        $serialisedSearchDetails = serialize(array('dowhat'=>$argDoWhat, 'withwhat'=>$argWithWhat, 'where'=> $argWhere));


        if (!empty($argWhere))
        {

            // /////////////////////////////////////////////////////////////////////
            // Log place - Insert search log (update if search already exists)
            // /////////////////////////////////////////////////////////////////////
            $modelSearchLogSummary = SearchLogSummary::model()->findByAttributes(array('search_tag' => $argWhere));
            if(!$modelSearchLogSummary)
            {
                $modelSearchLogSummary = new SearchLogSummary;
            }
            $modelSearchLogSummary->search_origin    = 'concierge';
            $modelSearchLogSummary->search_tag       = $argWhere   ;
            $modelSearchLogSummary->search_tag_type  = 'city';
            $modelSearchLogSummary->search_details   = $serialisedSearchDetails;
            $modelSearchLogSummary->search_count     = $modelSearchLogSummary->search_count + 1;
            $modelSearchLogSummary->save();

        }

        if (!empty($argDoWhat))
        {
            // /////////////////////////////////////////////////////////////////////
            // Log activity - Insert search log (update if search already exists)
            // /////////////////////////////////////////////////////////////////////
            $modelSearchLogSummary = SearchLogSummary::model()->findByAttributes(array('search_tag' => $argDoWhat));
            if(!$modelSearchLogSummary)
            {
                $modelSearchLogSummary = new SearchLogSummary;
            }
            $modelSearchLogSummary->search_origin    = 'concierge';
            $modelSearchLogSummary->search_tag       = $argDoWhat;
            $modelSearchLogSummary->search_tag_type  = 'activity';
            $modelSearchLogSummary->search_details   = $serialisedSearchDetails;
            $modelSearchLogSummary->search_count     = $modelSearchLogSummary->search_count + 1;
            $modelSearchLogSummary->save();
        }


        if (!empty($argWithWhat))
        {
            // /////////////////////////////////////////////////////////////////////
            // Log category - Insert search log (update if search already exists)
            // /////////////////////////////////////////////////////////////////////
            $modelSearchLogSummary = SearchLogSummary::model()->findByAttributes(array('search_tag' => $argWithWhat));
            if(!$modelSearchLogSummary)
            {
                $modelSearchLogSummary = new SearchLogSummary;
            }

            $modelSearchLogSummary->search_origin    = 'concierge';
            $modelSearchLogSummary->search_tag       = $argWithWhat;
            $modelSearchLogSummary->search_tag_type  = 'category';
            $modelSearchLogSummary->search_details   = $serialisedSearchDetails;
            $modelSearchLogSummary->search_count     = $modelSearchLogSummary->search_count + 1;
            $modelSearchLogSummary->save();
        }


        // Save the search in the history log
        $userId = Yii::app()->user->id;

        $searchHistory = array('user_id'          => ((Yii::app()->user->id===null)?1:Yii::app()->user->id),
            'search_origin'      => 'concierge',
            'created_time'       => new CDbExpression('NOW()'),
            'search_details'     => $serialisedSearchDetails
        );
        $modelSearchHistory  = new SearchHistory;
        $modelSearchHistory->attributes  = $searchHistory;
        $modelSearchHistory->save();

    }

    /**
     * Returns the list of activity types for the given activity
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionLoadactivitytype()
    {
        $reqActivity   = Yii::app()->request->getQuery("activity");
        $reqActivity   = filter_var($reqActivity,FILTER_SANITIZE_STRING);

        $lstActivityType    = ActivityType::model()->with('activity')->findAll("activity.keyword = :activity_keyword", array(':activity_keyword' => $reqActivity));

        echo ConciergeToolbar::getActivityType($lstActivityType);



        Yii::app()->end();

    }

    /**
     * Returns the list of friends to allow invitation.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionInvitefriends()
    {

        $businessId = $reqPanel   = Yii::app()->request->getQuery("business");

        // /////////////////////////////////////////////////////////////////////
        // First, get a list of all local friends
        // /////////////////////////////////////////////////////////////////////
        $lstMyFriends = MyFriend::model()->with('friend')->findAllByAttributes(array(
            'user_id' => Yii::app()->user->id
        ));

// TODO: We may not need to connect to Facebook at this stage.
//         // /////////////////////////////////////////////////////////////////////
//         // Now, get a list of the user's facebook friends
//         // /////////////////////////////////////////////////////////////////////
//         // Load the component
//         // TODO: figure why component is not autoloading.
//         $objFacebook = Yii::app()->getComponent('facebook');

//         // Establish a connection to facebook
//         $objFacebook->connect();

//         $lstMyOnlineFriends = array();
//         if ($objFacebook->isLoggedIn()) {
//             $lstMyOnlineFriends = $objFacebook->getFriendList();
//         }
// TODO: We may not need to connect to Facebook at this stage.

        $this->renderPartial("invite_friend_list", array(
            'myLocalFriends' => $lstMyFriends,
            'myOnlineFriends' => array(),
            'business_id'   => $businessId
        ));
    }

    /**
     * Sends invitations to list of selected friends.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionSendfriendinvitations()
    {

        $argBusinessId          = Yii::app()->request->getPost('business_id', null);
        $argBusinessId          = filter_var($argBusinessId,FILTER_SANITIZE_NUMBER_INT);

        $argInvitationList      = Yii::app()->request->getPost('invitation_list', array());

        $argMeetingDateTime     = Yii::app()->request->getPost('meeting_date_time', null);

        $argMessage             = Yii::app()->request->getPost('my_message', null);
        $argMessage             = filter_var($argMessage,FILTER_SANITIZE_STRING);

        // /////////////////////////////////////////////////////////////////////
        // Get the business entry
        // /////////////////////////////////////////////////////////////////////
        $modelBusiness          = Business::model()->with('businessCity')->findByPk( $argBusinessId );
        if ($modelBusiness === null)
        {
            header('Content-type: application/json');
            echo CJSON::encode(array(
                                    'result' => false,
                                    'message' => 'Cannot locate selected business '.$argBusinessId
                               ));
        }

        // /////////////////////////////////////////////////////////////////////
        // Get the email message template
        // /////////////////////////////////////////////////////////////////////
        $emailMessage = HAccount::getEmailMessage('invite friends');
        $emailSubject = HAccount::getEmailSubject('invite friends');

        // /////////////////////////////////////////////////////////////////////
        // Fetch the list of all invited friends
        // /////////////////////////////////////////////////////////////////////
        $dbCriteria = new CDbCriteria;

        $lstFriends = User::model()->findAllByPk($argInvitationList);

        foreach ($lstFriends as $itemMyFriend)
        {
            // Customise the email message
            $emailAttributes = array();
            $emailAttributes['friend_name']         = $itemMyFriend->first_name;
            $emailAttributes['venue']               = $modelBusiness->business_name;
            $emailAttributes['address']             = $modelBusiness->business_address1."\n".
                                                      $modelBusiness->business_address2."\n".
                                                      $modelBusiness->businessCity->city_name;
            $emailAttributes['meeting_date_time']   = $argMeetingDateTime;
            $emailAttributes['my_message']          = $argMessage;
            $emailAttributes['venue_url']           = Yii::app()->createAbsoluteUrl('businessuser/profile/show/', array('id' => $modelBusiness->business_id  ));
            $emailAttributes['my_name']             = Yii::app()->user->getFirstName();

            $customisedEmailMessage = HAccount::CustomiseMessage($emailMessage, $emailAttributes);


            // Send the message
            HAccount::sendMessage($itemMyFriend->email, $itemMyFriend->first_name.' '.$itemMyFriend->last_name, $emailSubject, $customisedEmailMessage);

        }

        header('Content-type: application/json');
        echo CJSON::encode(array(
            'result' => true,
            'message' => 'Invitations sent.'
        ));


    }

}