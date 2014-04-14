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

         // echo json_encode($listResults);
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
        $argPlace       = Yii::app()->request->getPost('where', null);

        // /////////////////////////////////////////////////////////////////////
        // If a place was entered, find the corresponding city id.
        // /////////////////////////////////////////////////////////////////////
        $cityId = 0;
        if (!empty($argPlace))
        {
            $modelCity  = City::model()->find(array('condition'=>'city_name=:city_name','params'=>array(':city_name' => $argPlace)));

            if ($modelCity != null)
            {
                $cityId = $modelCity->attributes['city_id'];
            }
        }

        $seachCriteria = new CDbCriteria;

        $seachCriteria->with = array('businessActivities',
                                     'businessActivities.activity');

        $seachCriteria->together = true;


        // $seachCriteria->select = array('business_name');

        if (!empty($cityId))
        {
            $seachCriteria->compare('business_city_id', $cityId);
        }

        if (!empty($argDoWhat))
        {
            $seachCriteria->compare('activity.keyword', $argDoWhat);
//             $seachCriteria->condition = "activity.keyword=:activity";
//             $seachCriteria->params = array(':activity' => $argDoWhat);

        }


        $seachCriteria->limit = Yii::app()->params['PAGESIZEREC+'];


        $dataProvider = new CActiveDataProvider('Business',
            array(
                'criteria'  => $seachCriteria,
            )
        );

        // /////////////////////////////////////////////////////////////////////
        // Log the search summary
        // /////////////////////////////////////////////////////////////////////
        $serialisedSearchDetails = serialize(array('dowhat'=>$argDoWhat, 'withwhat'=>$argWithWhat, 'where'=> $argPlace));


        if (!empty($argPlace))
        {

            // /////////////////////////////////////////////////////////////////////
            // Log place - Insert search log (update if search already exists)
            // /////////////////////////////////////////////////////////////////////
            $modelSearchLogSummary = SearchLogSummary::model()->findByAttributes(array('search_tag' => $argPlace));
            if(!$modelSearchLogSummary)
            {
                $modelSearchLogSummary = new SearchLogSummary;
            }
            $modelSearchLogSummary->search_origin    = 'concierge';
            $modelSearchLogSummary->search_tag       = $argPlace   ;
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
    private function  loadLeftPanel()
    {

        // /////////////////////////////////////////////////////////////////////
        // For non logged in users, show anonymous activity
        // For logged in users, show their friends
        // /////////////////////////////////////////////////////////////////////
        if (Yii::app()->user->isGuest)         // User is not logged in
        {
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
        else
        {
            // /////////////////////////////////////////////////////////////////
            // First, get a list of all local friends
            // /////////////////////////////////////////////////////////////////
            $lstMyFriends = MyFriend::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));

            // /////////////////////////////////////////////////////////////////
            // Now, get a list of the user's facebook friends
            // /////////////////////////////////////////////////////////////////
            // Load the component
            // TODO: figure why component is not autoloading.
            $objFacebook  = Yii::app()->getComponent('facebook');

            // Establish a connection to facebook
            $objFacebook->connect();

            $lstMyOnlineFriends = array();
            if ($objFacebook->isLoggedIn())
            {
                $lstMyOnlineFriends = $objFacebook->getFriendList();
            }


            $this->renderPartial("left_panel_friend_list", array('myLocalFriends'   => $lstMyFriends,
                                                                 'myOnlineFriends'  => $lstMyOnlineFriends
                                                                ));
            Yii::app()->end();


        }

    }
}