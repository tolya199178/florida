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
	public 	$layout='//layouts/front';

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

	    // /////////////////////////////////////////////////////////////////////
	    // Clear search
	    // /////////////////////////////////////////////////////////////////////

	    unset(Yii::app()->session['last_saved_search_id']);

	    // Get the user's location
        $myLocation = $this->getMyLocation();

	    $conciergeData = array();

	    // Pre-load the list of cities
	    $listCities                        = Yii::app()->db->createCommand()
                                                	       ->select("*")
                                                	       ->from('tbl_city')
                                                	       ->queryAll();
	    $conciergeData['listCities']       = $listCities;

	    // Load the current city
	    $conciergeData['myLocation']       = $myLocation;

	    // Get the users saved search list, for logged in users
	    if (!Yii::app()->user->isGuest)
	    {

	        $listSavedSearch = Yii::app()->db->createCommand()
                                	         ->select("*")
                                	         ->from('tbl_saved_search')
                                	         ->where('user_id = :user_id', array(':user_id' => Yii::app()->user->id))
                                	         ->queryAll();
	    }
	    else
	    {
	        $listSavedSearch = array();
	    }

	    $conciergeData['saved_searches'] = $listSavedSearch;




		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$this->render('concierge', array('data' => $conciergeData));
	}

    /**
     * Generates a JSON encoded list of all citys.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionPrefecthlistall()
    {


        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        $cityList          = City::model()->findAll($searchCriteria);

         $listResults = array();

         foreach($cityList as $recCity){
             $listResults[] = array('city_name' => $recCity->attributes['city_name']);
         }
          header('Content-type: application/json');

         echo CJSON::encode($listResults);



    }

    /**
     * Generates a JSON encoded list of saved search attributes
     *
     * @param int saved_search_id The PK of the search set via POST
     *
     * @return <none> <none>
     * @access public
     */
    public function actionGetsavedsearchjson()
    {

        // Do not action if the user is not logged in
        if (Yii::app()->user->isGuest)
        {
            $actionResult = array('result'      => false,
                                  'message'     => 'Not logged in',
                                  'search'     => null);

            echo CJSON::encode($actionResult);
            Yii::app()->end();
        }

        $argSavedSearchId       = Yii::app()->request->getPost('saved_search_id', null);

        // $modelSavedSearch       = SavedSearch::model()->findByPk((int) $argSavedSearchId);
        $listSavedSearch = Yii::app()->db->createCommand()
                                         ->select("*")
                                         ->from('tbl_saved_search')
                                         ->where('search_id = :search_id', array(':search_id' => $argSavedSearchId))
                                         ->limit('1')
                                         ->queryRow();

        if ($listSavedSearch === false)
        {
            $actionResult = array('result'      => false,
                                  'message'     => 'Saved search not found',
                                  'searche'     => null);
            echo json_encode($actionResult);
            Yii::app()->end();
        }

        $listSavedSearch['search_details'] = unserialize($listSavedSearch['search_details']);
        $actionResult = array('result'      => true,
                              'message'     => 'Success',
                              'search'      => $listSavedSearch);
        echo CJSON::encode($actionResult);
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
    public function actionDosearch()
    {


        $argDoWhat      = Yii::app()->request->getPost('dowhat', null);
        $argWithWhat    = Yii::app()->request->getPost('withwhat', null);
        $argWhere       = Yii::app()->request->getPost('where', null);
        $argWhen        = Yii::app()->request->getPost('dowhen', null);

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
        // We start  building the query for the search. The four important
        // ...filters are :-
        // ... - the city
        // ... - the activity
        // ... - the activity type
        // ... - the date for the search
        // ...The filters are not mandatory and all or at least one of the search
        // ...filters may be supplied.
        // /////////////////////////////////////////////////////////////////////
        $seachCriteria = new CDbCriteria;

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
               // TODO: Keep this query just in case the alternate proves too heavy
//             $seachCriteria->addCondition( "FIND_IN_SET(:activity_keyword_tag,`activity`.keyword) OR
//                                            FIND_IN_SET(:activity_related_word_tag,`activity`.related_words)"
//                                         );
//             $seachCriteria->params       = array_merge($seachCriteria->params,
//                                                        array(':activity_keyword_tag'=>$argDoWhat,
//                                                              ':activity_related_word_tag'=>$argDoWhat));

            $seachCriteria->addCondition( "FIND_IN_SET(:activity_keyword_tag,
                                          CONCAT(`activity`.keyword,',',`activity`.related_words))");
            $seachCriteria->params       = array_merge($seachCriteria->params,
                                                       array(':activity_keyword_tag'=>$argDoWhat));
        }

        // /////////////////////////////////////////////////////////////////////
        // Build the WHERE clause for the activity type filter. The activitytype
        // ...table is searched by matching the keyword and related word sets
        // ...to the activity keyword filter
        // /////////////////////////////////////////////////////////////////////
        if (!empty($argWithWhat))
        {
            $seachCriteria->addCondition( "FIND_IN_SET(:activity_type_keyword_tag,
                                          CONCAT(`activityType`.keyword,',',`activityType`.related_words))");

            $seachCriteria->params       = array_merge($seachCriteria->params,
                                                       array(':activity_type_keyword_tag'=>$argWithWhat));
               // TODO: Keep this query just in case the alternate proves too heavy
//             $seachCriteria->addCondition( "FIND_IN_SET(:activity_type_keyword_tag,`activityType`.keyword) OR
//                                            FIND_IN_SET(:activity_type_related_word_tag,`activityType`.related_words)"
//             );
//             $seachCriteria->params       = array_merge($seachCriteria->params,
//                 array(':activity_type_keyword_tag'=>$argWithWhat,
//                     ':activity_type_related_word_tag'=>$argWithWhat));
        }

        // /////////////////////////////////////////////////////////////////////
        // Submit the query
        // /////////////////////////////////////////////////////////////////////
        // BUG: Yii is not handling this query well and is returning different
        // BUG: ...results if we add a limit clause.
        // BUG: It appears the only way to handle this is to write a manual
        // BUG: ...SQL statement
        // BUG: eg, https://github.com/yiisoft/yii/issues/1846
        //
        // $seachCriteria->limit = Yii::app()->params['PAGESIZEREC'];

//         $dataProvider = new CActiveDataProvider('Business',
//             array(
//                 'criteria'  => $seachCriteria,
//                  'pagination'=> array(
//                      'pageSize'=>Yii::app()->params['PAGESIZEREC'],
//                  ),
//             )
//         );



        $listBusiness = Business::model()->findAll($seachCriteria);


        // /////////////////////////////////////////////////////////////////////
        // Log the search summary
        // /////////////////////////////////////////////////////////////////////
        $this->logSearch($argDoWhat, $argWithWhat, $argWhere, $argWhen);

        // /////////////////////////////////////////////////////////////////////
        // Search for events
        // /////////////////////////////////////////////////////////////////////
        // Search the event categories from the search keywords

        $listEvent = $this->searchEvents($argDoWhat, $argWithWhat, $argWhere, $argWhen);
        $this->renderPartial('search_results_container', array('model'              => $listBusiness,
                                                               'listEvent'          => $listEvent));

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
        $lastTimestamp = Yii::app()->request->getQuery("last_timestamp", null);

        if (($lastTimestamp === null) OR ((int) $lastTimestamp == 0))
        {
            $lastTimestamp = strtotime("-1 week");
        }


        // /////////////////////////////////////////////////////////////////////
        // For 'new' feeds' show recent activity for all users. A 'new' feed is
        // ...a page load where a search has not been submitted yet.
        // For 'old' feeds' show similar search activity. A feed is 'old' once
        // ...a user has submitted a search (the last search history id is
        // ...stored in session.
        // /////////////////////////////////////////////////////////////////////

        $dbCriteria = new CDbCriteria;
        // TODO: Move the search limit to parameters file
        $dbCriteria->condition = " unix_timestamp(created_time) > :lastTimestamp ";
        $dbCriteria->params    = array(':lastTimestamp' => $lastTimestamp);
        $dbCriteria->limit     = 100;
        $dbCriteria->order     = 'created_time DESC';

        if (isset(Yii::app()->session['last_saved_search_id']))
        {

            $lastSearch = SavedSearch::model()->findByPk(Yii::app()->session['last_saved_search_id']);

            if ($lastSearch != null)
            {
                $dbCriteria->addCondition(' filter_activity = :filter_activity AND filter_activitytype = :filter_activitytype ');
                $dbCriteria->params    = array_merge($dbCriteria->params, array(':filter_activity' => $lastSearch->filter_activity,
                                                                                ':filter_activitytype' => $lastSearch->filter_activitytype
                                                     ));
            }

        }


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

                // If there are no images, load the no-image by creating a psudeo-model. Remember not to save!
                if (count($lstCityPhotos) <= 0)
                {
                    $psuedoPhotoModel = new Photo();
                    $psuedoPhotoModel->attributes =
                        array('photo_type'  => 'city',
                            'title'       => 'No image found',
                            'caption'     => 'No image found',
                            'path'        => Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH']
                        );

                    $lstCityPhotos[]    = $psuedoPhotoModel;

                }

                $this->renderPartial('city_gallery', array('lstCityPhotos'=> $lstCityPhotos));


                Yii::app()->end();

            }

        }

    }

    /**
     * Logs the search.
     *
     * @param $argDoWhat string Activity search rule
     * @param $argWithWhat string ActivityType search rule
     * @param $argWhere string Location search rule
     * @param $argWhen string Date search rule
     *
     * @return <none> <none>
     * @access public
     */
    private function logSearch($argDoWhat, $argWithWhat, $argWhere, $argWhen)
    {

        $serialisedSearchDetails = serialize(array('dowhat'=>$argDoWhat, 'withwhat'=>$argWithWhat, 'where'=> $argWhere, 'when'=> $argWhen));


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
            'filter_activity'    => $argDoWhat,
            'filter_activitytype'   => $argWithWhat,
            'search_details'     => $serialisedSearchDetails
        );
        $modelSearchHistory  = new SearchHistory;
        $modelSearchHistory->attributes  = $searchHistory;
        $modelSearchHistory->save();

        // /////////////////////////////////////////////////////////////////////
        // Save the search to the Session
        // /////////////////////////////////////////////////////////////////////
        Yii::app()->session['last_saved_search_id'] = $modelSearchHistory->search_id;


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
        $reqActivity   = filter_var($reqActivity,FILTER_SANITIZE_NUMBER_INT);

        $lstActivityType    = ActivityType::model()->findAllByAttributes(array('activity_id' => $reqActivity));


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

    private function getNearestCity($posLatitude, $posLongitude)
    {

        $existing = Yii::app()->db->createCommand()
        ->select("* ,  6371.04 * acos( cos( pi( ) /2 - radians( 90 - Latitude) )
                                      *cos( pi( ) /2 - radians( 90 - '$posLatitude' )
                                     ) *
                                  cos( radians(Longitude) - radians( '$posLongitude' ) )
                                    + sin( pi( ) /2 - radians( 90 - Latitude) )
                                    * sin( pi( ) /2 - radians( 90 - '$posLatitude' ) )
                                    ) AS Distance")
        ->from('tbl_city')
        ->limit('0, 10')
        ->group('city_id')
        ->having('')
        ->queryRow();

        /*
         * SELECT * , 6371.04 * acos( cos( pi( ) /2 - radians( 90 - Latitude) )
* cos( pi( ) /2 - radians( 90 - '$latitude' ) ) * cos( radians(
Longitude) - radians( '$longitude' ) ) + sin( pi( ) /2 - radians( 90
- Latitude) ) * sin( pi( ) /2 - radians( 90 - '$latitude' ) ) ) AS
Distance
FROM MyLocations
WHERE ( 6371.04 * acos( cos( pi( ) /2 - radians( 90 - Latitude) ) *
cos( pi( ) /2 - radians( 90 - '$latitude' ) ) * cos( radians(
Longitude) - radians( '$longitude' ) ) + sin( pi( ) /2 - radians( 90
- Latitude) ) * sin( pi( ) /2 - radians( 90 - '$latitude' ) ) ) <1 )
GROUP BY one_id HAVING dist < '$radius'
ORDER BY Distance
LIMIT 0 , $numberOfResults
         */

    }

    /**
     * Searches the local event listing using the search criteria entered by the user.
     *
     * @param $argDoWhat string Activity search rule
     * @param $argWithWhat string ActivityType search rule
     * @param $argWhere string Location search rule
     * @param $argWhen string Date search rule
     *
     * @return eventList array List of events matching criteria
     * @access public
     */
    private function searchEvents($argDoWhat, $argWithWhat, $argWhere, $argWhen)
    {

        // /////////////////////////////////////////////////////////////////////
        // Search for the list of activities related to the user search. We want
        // ...to match the user search and extract the event_category from the
        // ...activity table.
        // /////////////////////////////////////////////////////////////////////

        $activitySearchCriteria = new CDbCriteria();
        $activitySearchCriteria->join = 'LEFT JOIN tbl_activity_type b ON b.activity_id = t.activity_id ';

        if (! empty($argDoWhat)) {
            $activitySearchCriteria->addCondition("FIND_IN_SET(:activity_keyword_tag,`t`.keyword) OR
                                                   FIND_IN_SET(:activity_related_word_tag,`t`.related_words)");
            $activitySearchCriteria->params = array_merge($activitySearchCriteria->params, array(
                ':activity_keyword_tag' => $argDoWhat,
                ':activity_related_word_tag' => $argDoWhat
            ));
        }

        if (! empty($argWithWhat)) {
            $activitySearchCriteria->addCondition("FIND_IN_SET(:activity_type_keyword_tag,`b`.keyword) OR
                                                    FIND_IN_SET(:activity_type_related_word_tag,`b`.related_words)", "OR");
            $activitySearchCriteria->params = array_merge($activitySearchCriteria->params, array(
                ':activity_type_keyword_tag' => $argWithWhat,
                ':activity_type_related_word_tag' => $argWithWhat
            ));
        }

        $listActivity = Activity::model()->findAll($activitySearchCriteria);

        // /////////////////////////////////////////////////////////////////////
        // The activities willl appear as lists of comma-delimited keywords. We
        // ...expand these lists further to produce a flatted single list.
        // /////////////////////////////////////////////////////////////////////
        $listEventCategory = array();
        foreach ($listActivity as $itemActivity) {
            $setEventCategory = $itemActivity->event_categories;
            $listActvityCategory = explode(",", $setEventCategory);
            $listEventCategory = array_merge($listEventCategory, $listActvityCategory);
        }

        if (count($listEventCategory) == 0) {
            $listEventCategory[] = 'other';
        }

        $listEventCategory = array_map('trim', $listEventCategory);

        // /////////////////////////////////////////////////////////////////////
        // We list all events that match the list of search categories.
        // /////////////////////////////////////////////////////////////////////

        $listEvent = Yii::app()->db->createCommand()
                        ->select("t.*, tne.*")
                        ->from('tbl_event t')
                        ->leftJoin('tbl_tn_event tne', 'tne.tn_id = t.external_event_id')
                        ->leftJoin('tbl_event_category ec', 'ec.category_id = tne.tn_parent_category_id')
                        ->where('external_event_source = "ticketnetwork"')
                        ->andWhere(array('in', 'TRIM(ec.category_name)', $listEventCategory))
                        ->queryAll();

        return $listEvent;

    }

    /**
     * Determines the users location based on the IP address, or assign the
     * ...default city for the user.
     *
     * @param <none> <none>
     *
     * @return cityModel City{} model of the user's location
     * @access public
     */
    private function getMyLocation()
    {

        // TODO: This need to go into the system settings
        // TODO: User test data until the city database is properly populated
        // $defaultCityList   = array('Miami', 'Palm Beach', 'Key West');
        $defaultCityList   = array('Miami');
        $defaultCityKey    = array_rand($defaultCityList, 1);
        $defaultCity       = $defaultCityList[$defaultCityKey];


        // /////////////////////////////////////////////////////////////////////
        // Get the local IP address, If this is a private IP, change it to the
        // ...default. This should only happen in a dev environment.
        // /////////////////////////////////////////////////////////////////////
        $isPrivateIP = !filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE);

        if ($isPrivateIP) {

            $myCity = $defaultCity;

        }
        else
        {
            // Find the user location based the IP address
            $myIpAddress        = $_SERVER['REMOTE_ADDR'];

            // Get my current location
            $myLocation         = Yii::app()->geoip->lookupLocation($myIpAddress);
            $myLocationDetails  = $myLocation->aData;

            $myCity = $myLocation->city;

            // /////////////////////////////////////////////////////////////////
            // If the user is not local to a florida address, assign the user to
            // ...a default location
            // /////////////////////////////////////////////////////////////////
            if (($myLocation->countryName != 'United States') || ($myLocation->regionName != 'Florida'))
            {
                $myCity = $defaultCity;
            }

        }



        // /////////////////////////////////////////////////////////////////////
        // Find the home city in our own list of city. If the city is not found,
        // ...set it to the default city
        // /////////////////////////////////////////////////////////////////////
        $cityModel      = City::model()->findByAttributes(array('city_name' => $myCity));

        if ($cityModel === null)
        {
            $myCity         = $defaultCity;
            $cityModel      = City::model()->findByAttributes(array('city_name' => $myCity));
        }

        return $cityModel;

    }

    /**
     * Save the current search.
     * ...
     * ...Do not action if the user is not logged in
     * ...Do not action is the search is already saved.
     * ...Do not action if there is no search saved in the session.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionSavesearch()
    {
        // Do not action if the user is not logged in
        if (Yii::app()->user->isGuest)
        {
            echo CJSON::encode(array('result'=>false, 'message'=>'Not logged in'));
            Yii::app()->end();
        }

        // Do not action if there is no search saved in the session.
        if (!isset(Yii::app()->session['last_saved_search_id']))
        {
            echo CJSON::encode(array('result'=>false, 'message'=>'No search found'));
            Yii::app()->end();
        }

        // Search the search history log. The search history is a temporary transactional
        // ...log table and may be cleaned up from time to time for operational reasons. If
        // ...the search is no longer available, we exit with an error message.
        $itemSearchLog = SearchHistory::model()->findByPk(Yii::app()->session['last_saved_search_id']);

        $searchDetails = unserialize($itemSearchLog->search_details);


        // /////////////////////////////////////////////////////////////////////
        // Save the details into the saved search table
        // /////////////////////////////////////////////////////////////////////
        $modelSavedSearch = SavedSearch::model()->findByAttributes(
                                                    array('user_id'             => Yii::app()->user->id,
                                                          'filter_activity'     => $searchDetails['dowhat'],
                                                          'filter_activitytype' => $searchDetails['withwhat'],
                                                  ));
        if ($modelSavedSearch !== null )
        {
            echo CJSON::encode(array('result'=>false, 'message'=>'Search already saved'));
        }


        // Create a new object to be added to the saved search table
        $modelSavedSearch = new SavedSearch;
        $modelSavedSearch->user_id                  = Yii::app()->user->id;
        $modelSavedSearch->filter_activity          = $searchDetails['dowhat'];
        $modelSavedSearch->filter_activitytype      = $searchDetails['withwhat'];
        $modelSavedSearch->search_details           = $itemSearchLog->search_details;
        $modelSavedSearch->search_name              = $searchDetails['dowhat'].' '.$searchDetails['withwhat']. ' IN '.$searchDetails['where'].' ON '.$itemSearchLog->created_time;

        if ($modelSavedSearch->save() === false)
        {
            echo CJSON::encode(array('result'=>false, 'message'=>'Problem saving saved search. Contact administrator.'));
            Yii::app()->end();

        }
        else
        {
            echo CJSON::encode(array('result'=>true, 'message'=>'Saved.'));
            Yii::app()->end();
        }

    }

    /**
     * Renders JSON results of activities.
     * Used for dropdowns
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionActivitylist()
    {

        $strSearchFilter = $_GET['query'];

        // Don't process short request to prevent load on the system.
        if (strlen($strSearchFilter) < 2)
        {
            header('Content-type: application/json');
            return "";
            Yii::app()->end();

        }

        $lstActivity = Yii::app()->db
                                ->createCommand()
                                ->select('activity_id AS id, keyword AS text')
                                ->from('tbl_activity')
                                ->where(array('LIKE', 'keyword', '%'.$_GET['query'].'%'))
                                ->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($lstActivity);

    }

    /**
     * Renders JSON results of activity types
     * Used for dropdowns
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionActivitytypelist()
    {

        $strSearchFilter = $_GET['query'];

        // Don't process short request to prevent load on the system.
        if (strlen($strSearchFilter) < 2)
        {
            header('Content-type: application/json');
            return "";
            Yii::app()->end();

        }

        $lstActivityType = Yii::app()->db
                                    ->createCommand()
                                    ->select('activity_id AS id, keyword AS text')
                                    ->from('tbl_activity_type')
                                    ->where(array('LIKE', 'keyword', '%'.$_GET['query'].'%'))
                                    ->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($lstActivityType);

    }

}