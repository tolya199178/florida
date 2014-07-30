<?php

/**
 * Business Controller interface for the Frontend (Public) Business Module
 */


/**
 * BusinessController is a class to provide access to controller actions for general
 * ..processing of business browsing. The contriller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/business/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/business/profile/show/name/toms-diner/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /business/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /business/profile/show/name/toms-diner/ will pass $_GET['name'] = 'toms-diner'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */


Yii::import("application.modules.webuser.components.HAccount");


class BusinessController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * The default action method
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {
        CController::forward('/business/business/browse/');
    }

    /**
     * Displays the profile for the given Business id
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionShowlisting()
    {

        $argCategoryId = (int) Yii::app()->request->getQuery('category', 0);
        $argPage       = (int) Yii::app()->request->getQuery('page', 0);

        $currentCategory = 	$argCategoryId;

        // /////////////////////////////////////////////////////////////////////
        // Get a listing of businesses for the current category
        // /////////////////////////////////////////////////////////////////////
        $dbCriteria             = new CDbCriteria;
        $dbCriteria->with       = array('businessCategories');
        $dbCriteria->limit      = (int) Yii::app()->params['PAGESIZEREC'];
        $dbCriteria->offset     = $argPage * $dbCriteria->limit;

        // NOTE: Add this otherwise Yii removes the relation from the query.
        // https://code.google.com/p/yii/issues/detail?id=2678
        $dbCriteria->together   = true;

        $dbCriteria->condition  = 'businessCategories.category_id = :category_id';

        if (empty($currentCategory))
        {
            $dbCriteria->addCondition('businessCategories.category_id IS NULL', 'OR');
        }

        $dbCriteria->params     = array(':category_id' => $currentCategory);

        $listBusiness   = Business::model()->findAll($dbCriteria);

        $this->renderPartial('business_list', array('listBusiness' => $listBusiness));

    }

    /**
     * Displays the business listing screen
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionBrowse()
	{

	    $argCategoryId = (int) Yii::app()->request->getQuery('category', 0);

        $currentCategory = 	$argCategoryId;

        // /////////////////////////////////////////////////////////////////////
        // Get details about the current category
        // /////////////////////////////////////////////////////////////////////
        $categoryRecord = Yii::app()->db->createCommand()
                                        ->select('category_id, parent_id, category_name')
                                        ->from('tbl_category')
                                	    ->where('category_id = :category', array(':category'=>$currentCategory))
                                	    ->limit('1')
                                	    ->queryRow();

        $currentCategoryListItem = array(array('id'=>$categoryRecord['category_id'], 'name'=> $categoryRecord['category_name']));

        // /////////////////////////////////////////////////////////////////////
        // Get the current category path
        // /////////////////////////////////////////////////////////////////////
        $categoryBreadcrumb = $this->getCategoryTreeIDs($currentCategory);


        // /////////////////////////////////////////////////////////////////////
        // Get the list of subcategories of the current category
        // /////////////////////////////////////////////////////////////////////
        $cmdSubCategoryList = Yii::app()->db->createCommand()
                                         ->select('category_id, parent_id, category_name')
                                         ->from('tbl_category');
        if (empty($currentCategory))
        {
            $cmdSubCategoryList->where('parent_id = 0 OR parent_id  IS NULL', array(':category_id'=>$currentCategory));
        }
        else
        {
            $cmdSubCategoryList->where('parent_id = :category_id', array(':category_id'=>$currentCategory));
        }

        $listSubcategory = $cmdSubCategoryList->queryAll();

        $listCities  = City::model()->findAll();

        $this->render('browse', array('category_path'     => $categoryBreadcrumb,
                                      'listSubcategories' => $listSubcategory,
                                      'currentCategory'   => $currentCategory,
                                      'listCities'        => $listCities
                              ));
	}


	/**
	 * Returns the category path in the category tree for the given category.
	 *
	 * The given category is located in the category tree and an upward path to
	 * ...the category tree root is provided. The tree is provided in 'reverse'
	 * ...order, so that the hierarchical relationship can be shown.
	 *
	 * ...The tree root node is not shown (and is assumed to be 'Category')
	 *
	 * @param int $catID
	 *
	 * @return array The list of items in the category path.
	 * @access public
	 */
	private	function getCategoryTreeIDs($catID)
	{

	    if (!empty($catID))
	    {

	        // Obtain the category details
	        $row = $categoryList = Yii::app()->db->createCommand()
                                	         ->select('category_id, parent_id, category_name')
                                	         ->from('tbl_category')
                                	         ->where('category_id = :category', array(':category'=>$catID))
                                	         ->limit('1')
                                	         ->queryRow();

	        $path = array();
	        // /////////////////////////////////////////////////////////////////
	        // If the category has a parent, obtain the parent path listing and
	        // ...prepend to the category listing. Otherwise just return the
	        // ...category listing.
	        // /////////////////////////////////////////////////////////////////
	        if (!empty($row['parent_id'])) {
	            $path[] = array('id'=>$row['category_id'], 'name'=> $row['category_name']);
	            $path = array_merge($this->getCategoryTreeIDs($row['parent_id']), $path);
	            return $path;
	        }
	        else
	        {
	            $path[] = array('id'=>$row['category_id'], 'name'=> $row['category_name']);
	            return $path;
	        }

	    }
	    else
	    {
	        // No match. Just be nice and return an empty array.
            return array();
	    }


    }

    /**
     * Adds a new business entry.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionAdd()
    {
        // /////////////////////////////////////////////////////////////////////
        // This function is only available to users that are logged in. Other
        // ...users are given a friendly notice and gentle request to log in
        // ...or join.
        // /////////////////////////////////////////////////////////////////////
        $userId = Yii::app()->user->id;

        if ($userId === null)         // User is not known
        {
            Yii::app()->user->setFlash('warning','You must be logged in to perform this action.');
            $this->redirect(array('/webuser/account/register'));
            Yii::app()->end();
        }

		$businessModel = new Business;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($businessModel);

	    if(isset($_POST['Business']))
	    {

	        $businessModel->attributes             = $_POST['Business'];
	        $businessModel->lstBusinessCategories  = $_POST['Business']['lstBusinessCategories'];


	        if($businessModel->save())
	        {

	            $myAccount = User::model()->findByPk(Yii::app()->user->id);

	            // /////////////////////////////////////////////////////////////////////
	            // Assign the primary business user
	            // /////////////////////////////////////////////////////////////////////
	            $modelBusinessUser                 = new BusinessUser;
	            $modelBusinessUser->business_id    = $businessModel->business_id;
	            $modelBusinessUser->user_id        = $myAccount->user_id;
	            $modelBusinessUser->primary_user   = 'Y';

	            if ($modelBusinessUser->save() === false)
	            {
	                throw new CHttpException(400,'Bad Request. Could not save business user record.');
	            }


	            // /////////////////////////////////////////////////////////////////////
	            // Get the email message template
	            // /////////////////////////////////////////////////////////////////////
	            $emailMessage = HAccount::getEmailMessage('business registered');
	            $emailSubject = HAccount::getEmailSubject('business registered');


	            // Customise the email message
	            $emailAttributes = array();
	            $emailAttributes['first_name']         = $myAccount->first_name;
	            $emailAttributes['last_name']          = $myAccount->last_name;

	            $emailAttributes['business_name']      = $businessModel->business_name;


	            $customisedEmailMessage = HAccount::CustomiseMessage($emailMessage, $emailAttributes);


	            // Send the message
	            HAccount::sendMessage($myAccount->email, $myAccount->first_name.' '.$myAccount->last_name, $emailSubject, $customisedEmailMessage);






	            Yii::app()->user->setFlash('success', "The business has been created and submitted for approval*.");

	            $idNewBusiness = $businessModel->business_id;
	            $this->redirect(array('/businessuser/profile/show', 'id' => $idNewBusiness));

	        }
	        else {
                Yii::app()->user->setFlash('error', "Error creating a business record.");
	        }


	    }

	    // Show the details screen
	    $this->render('register/business_register',array('model'=>$businessModel));

    }

    /**
     * Displays the profile for the given Business id
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionShow()
    {

        $argBusinessId = (int) Yii::app()->request->getQuery('id', null);

        if ($argBusinessId)
        {
            $modelBusiness = Business::model()->findByPk($argBusinessId);

            if ($modelBusiness === null)
            {
                throw new CHttpException(404,'No such user. The requested user page does not exist.');
            }
            else
            {
                // Get photos
                // TODO: We should look into implementing this woth relations.
                $listPhotos = Photo::model()->findAllByAttributes(array('entity_id' => $argBusinessId, 'photo_type' => 'business'));


                $this->renderPartial('profile/profile_modal', array('model'=>$modelBusiness, 'photos' => $listPhotos));
            }
        }
        else
        {
            throw new CHttpException(404,'No user supplied. The requested user page does not exist.');
        }
    }

    /**
     * Processes a request to reporr a business a closed
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionReportClosed()
    {

        // /////////////////////////////////////////////////////////////////////
        // This function is only available to users that are logged in. Other
        // ...users are given a friendly notice and gentle request to log in
        // ...or join.
        // /////////////////////////////////////////////////////////////////////
        $userId = Yii::app()->user->id;

        if ($userId === null)         // User is not known
        {
            Yii::app()->user->setFlash('warning','You must be logged in to perform this action.');
            $this->redirect(array('/webuser/account/register'));
            Yii::app()->end();
        }


        $argBusinessId = (int) Yii::app()->request->getQuery('business_id', null);

        if ($argBusinessId)
        {
            $modelBusiness = Business::model()->findByPk($argBusinessId);

            if ($modelBusiness === null)
            {
                throw new CHttpException(404,'No such business. The requested business page does not exist.');
            }
            else
            {
                $modelBusiness->report_closed_reference = $_POST['reference'];

                if ($friendModel->save())
                {
                    Yii::app()->user->setFlash($flashMessageType, $flashMessage);
                    $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                    Yii::app()->end();

                }
                else
                {
                    Yii::app()->user->setFlash('warning','Your request could not be handled at this time. Try again later.
	                                           Contact the administrator if the problem persists.');
                    $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                    Yii::app()->end();
                }

            }
        }
        else
        {
            throw new CHttpException(404,'No business supplied. The requested business page does not exist.');
        }
    }

   /**
     * Calculates the certificate for the logged in user, or for the current business.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     */
    private function getCertificateSummary($businessId = null)
    {

        if ($businessId === null)
        {
            // lists certificates of all business of the current user
            $inDdbCriteria              = new CDbCriteria();
            $inDdbCriteria->with        = array('businessUsers');
            $inDdbCriteria->condition   = "businessUsers.user_id = :user_id";
            $inDdbCriteria->params      = array(':user_id' => Yii::app()->user->id);

            $businessList               = Business::model()->findAll($inDdbCriteria);
            $businessIds                = array();

            foreach ($businessList as $businessItem)
            {
                array_push($businessIds, $businessItem['business_id']);
            }
        }
        else
        {

            $businessIds                = array();
            array_push($businessIds, $businessId);
        }




        $dbCriteria                 = new CDbCriteria();
        $dbCriteria->addInCondition('business_id', $businessIds);

        $lstAllMyCertificates       = RestaurantCertificate::model()->findAll($dbCriteria);

        $summaryResults             = array('countAll'      => 0,
                                            'countIssued'   => 0,
                                            'countUnIssued' => 0,
                                            'countRedeemed' => 0);

        foreach ($lstAllMyCertificates as $itemCertificate)
        {
            $summaryResults['countAll']++;

            if (!empty($itemCertificate->redeem_code))
            {
                $summaryResults['countIssued']++;
            }
            else
            {
                $summaryResults['countUnIssued']++;
            }

            if (!empty($itemCertificate->redeem_date))
            {
                $summaryResults['countRedeemed']++;
            }

        }

        return $summaryResults;

    }

    /**
     * Displays the user's business dashboard.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionDashboard()
    {

        // /////////////////////////////////////////////////////////////////////
        // This function is only available to users that are logged in. Other
        // ...users are given a friendly notice and gentle request to log in
        // ...or join.
        // /////////////////////////////////////////////////////////////////////
        $userId = Yii::app()->user->id;

        if ($userId === null)         // User is not known
        {
            Yii::app()->user->setFlash('warning','You must be logged in to perform this action.');
            $this->redirect(array('/webuser/account/register'));
            Yii::app()->end();
        }

        $argCurrentBusiness = Yii::app()->request->getQuery('business', null);

        if ($argCurrentBusiness != null)
        {
            $dashboardMainpanel = 'biz_stats';
        }
        else
        {
            $dashboardMainpanel = 'default';
        }


        // /////////////////////////////////////////////////////////////////////
        // Get the user's businesses
        // /////////////////////////////////////////////////////////////////////

        $dbCriteria                         = new CDbCriteria();
        $dbCriteria->with                   = array('businessUsers');
        $dbCriteria->condition              = "businessUsers.user_id = :user_id";
        $dbCriteria->params                 = array(':user_id' => Yii::app()->user->id);

        $listMyBusiness = Business::model()->findAll($dbCriteria);

        // /////////////////////////////////////////////////////////////////////
        // Get the user's certificate summary
        // /////////////////////////////////////////////////////////////////////
        $myCertificateSummary               = $this->getCertificateSummary($argCurrentBusiness);
        $myCouponSummary                    = $this->getCouponSummary($argCurrentBusiness);
        $myBannerSummary                    = $this->getBannerTop5($argCurrentBusiness);



        $viewsCount = array('totalPageViews'    => Yii::app()->dashboardstats->totalPageViews($argCurrentBusiness, 'business'),
                            'totalBannerViews'  => Yii::app()->dashboardstats->totalBannerViewsByBusiness($argCurrentBusiness),
                            'totalReviews'      => Yii::app()->dashboardstats->totalReviewsByBusiness($argCurrentBusiness)
                      );


        $configDashboard = array('leftPanel'        => 'left_panel',
                                 'mainPanel'        => $dashboardMainpanel
                           );



        $dashboardData = array('listMyBusiness'     => $listMyBusiness,
                               'viewsCount'         => $viewsCount,
                               'currentBusiness'    => Business::model()->findByPk((int) $argCurrentBusiness),
                               'myCertificateSummary' => $myCertificateSummary,
                               'myBannerSummary'    => $myBannerSummary,
                               'myCouponSummary'    => $myCouponSummary);


        $this->render('dashboard/dashboard_main', array('config'=>$configDashboard, 'data'=>$dashboardData));

    }

    /**
     * Renders JSON results of friend search in {id,text,image} format.
     * Used for dropdowns
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionAutocompletelist()
    {

        $strSearchFilter = $_GET['query'];

        // Don't process short request to prevent load on the system.
        if (strlen($strSearchFilter) < 2)
        {
            header('Content-type: application/json');
            return "";
            Yii::app()->end();

        }

        $lstBusiness = Yii::app()->db
                                 ->createCommand()
                                 ->select('busines_id AS id, business_name AS text')
                                 ->from('tbl_business')
                                 ->where(array('LIKE', 'business_name', '%'.$_GET['query'].'%'))
                                 ->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($lstBusiness);

    }

    /**
     * Displays view to claim business
     *
     * @param integer $business_id id of the business to claim
     * @return <none> <none>
     */
    public function actionClaim()
    {

        $businessId = (int) Yii::app()->request->getQuery('business_id');

        $businessModel = Business::model()->findByPk((int) $businessId);

        if ($businessModel === null)
        {
            throw new CHttpException(404,'The requested business does not exist.');
        }

        // Checks if the business has users already
        if (count($businessModel->businessUsers) > 0)
        {
            $this->render('claim/isclaimed');
            Yii::app()->end();
        }

        // renders the claim page
        $this->render('claim/index', array('business' => $businessModel));
    }

    /**
     * Request to make a call via twilio
     *
     * @param <none> <none>
     * @return <none> <none>
     */
    public function actionClaimcall()
    {

        // Import twilio helper classes
        Yii::import('application.vendor.*');

        spl_autoload_unregister(array('YiiBase','autoload'));
        require Yii::getPathOfAlias('webroot') . '/protected/vendors/Services/Twilio.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        // inits the output result
        $result = array('success' => false);

        // check basic data

        // Checks if the business exists
        $businessModel = Business::model()->findByPk((int) (Yii::app()->request->getPost('businessId', 0)));

        if(!$businessModel)
        {
            $result['error'] = 'wrong business';
        }
        else
        {
            // checks if phone displayed to the user matches the business phone
            $phone = Yii::app()->request->getPost('businessPhone', '');

            if($phone != $businessModel->business_phone)
            {
                $result['error'] = 'phone missmatch: ' . $phone . ' - ' . $businessModel->business_phone;
            }
            else
            {
                // Checks if the user trying to claim the business is valid
                $userModel = User::model()->findByPk(Yii::app()->user->id);
                if(!$userModel)
                {
                    $result['error'] = 'wrong user';
                }
            }
        }

        // if basic data has no error generates the code and makes the call
        if(!isset($result['error']))
        {
            // generate code
            $code = rand(100000, 999999);

            //Deletes previous twilio_business_verification records linked to the same phone
            TwilioBusinessVerification::model()->deleteAllByAttributes(array('phone' => $phone));


            // Creates twilio object
            $twilioAcountId = Yii::app()->params['TWILIO_ACCOUNT_SID'];
            $twilioAuthToken = Yii::app()->params['TWILIO_AUTH_TOKEN'];
            $twilioCallerPhone = Yii::app()->params['TWILIO_PHONE'];
            $client = new Services_Twilio($twilioAcountId, $twilioAuthToken);

            try {

                // URL called by twilio when makin the call
                $callUrl                            = $this->createAbsoluteUrl('business/twiliocallback');
                $callStatusUrl                      = $this->createAbsoluteUrl('business/twiliocallstatus/');
                // Makes the call
                $client->account->calls->create($twilioCallerPhone, $phone, $callUrl, array(
                        'StatusCallback' => $callStatusUrl,
                    ));

                $callSid                            = $client->last_response->sid;
                // Inits a new twilio_business_verification record
                $twilioVerification                 = new TwilioBusinessVerification();
                $twilioVerification->phone          = $phone;
                $twilioVerification->code           = $code;
                $twilioVerification->business_id    = $business->business_id;
                $twilioVerification->user_id        = $user->user_id;
                $twilioVerification->call_sid       = $callSid;
                $twilioVerification->save();

                // Update resutl data
                $result['success']                  = true;
                $result['code']                     = $code;
                $result['verificationId']           = $twilioVerification->twilio_business_verification_id;
                $result['callSid']                  = $callSid;
                $result['error']                    = json_encode($twilioVerification->errors);

            }
            catch (Exception $ex) {
                // error making the call
                $result['error'] = 'error starting phone call ' . $ex->getMessage();
            }
        }

        // output results
        echo CJSON::encode($result);
    }

    /**
     * Action called by twilio when it makes a call
     */
    public function actionTwiliocallback() {
        // Import twilio helper classes
        Yii::import('application.vendor.*');
        spl_autoload_unregister(array('YiiBase','autoload'));
        require Yii::getPathOfAlias('webroot') . '/protected/vendors/Services/Twilio.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        // creates twilio response object
        $response = new Services_Twilio_Twiml();

        // if a code entered by user in the phone isn't posted request for the code
        if(empty($_POST['Digits'])) {
            // request a 6 digit code
            $gather = $response->gather(array('numDigits' => 6));
            // request message
            $gather->say('Please enter your verification code');
        } else {
            // if a code is posted find a twilio_business_verification record linked to the current phone
            $twilioVerification = TwilioBusinessVerification::model()->findByAttributes(array('call_sid' => Yii::app()->request->getpost('CallSid', '')));
            // if a twilio_business_verification record exists and code matches the code enteed by the user
            if($twilioVerification && $twilioVerification->code == Yii::app()->request->getPost('Digits', '')) {
                // finds a business user linked to the business being claimed
                $businessUser = BusinessUser::model()->findByAttributes(array('business_id' => $twilioVerification->business_id));
                // if a business user already exists responds with a business already claimed message
                // else it assigns the business to the user
                if($businessUser) {
                    $twilioVerification->status = 'taken';
                    $twilioVerification->save();
                    $response->say('Business was already claimed');
                } else {
                    // creates and saves new business user
                    $businessUser = new BusinessUser();
                    $businessUser->user_id = $twilioVerification->user_id;
                    $businessUser->business_id = $twilioVerification->business_id;
                    $businessUser->primary_user = 'Y';
                    $businessUser->save();
                    // updates twilio_business_verification record to verified
                    $twilioVerification->status = 'verified';
                    $twilioVerification->save();
                    // responds
                    $response->say('Thank you! you have claimed this business');
                }
            } else {
                // update twilio_business_verification record status
                $twilioVerification->status = 'failed';
                $twilioVerification->attempts++;
                $twilioVerification->save();
                if($twilioVerification->attempts > 5) {
                    $response->say('Verification failed');
                }else {
                    // if code was incorrect request to enter a new one
                    $gather = $response->gather(array('numDigits' => 6));
                    $gather->say('Verification code incorrect, please try again.');
                }
            }
        }

        print $response;
    }

    /*
     * Checks verification status.
     */
    public function actionTwilioverificationstatus() {
        // inits result
        $result = array('success' => false);
        // find business twilio_business_verification record
        $twilioVerification = TwilioBusinessVerification::model()->findByPk(Yii::app()->request->getPost('verificationId', 0));
        // if record exists posts the current status
        if($twilioVerification) {
            $result['success'] = true;
            $result['status'] = $twilioVerification->status;
            $result['callStatus'] = $twilioVerification->call_status;
        }
        echo json_encode($result);
    }

    /**
     * Called by twilio after call end with call result information
     */
    public function actionTwiliocallstatus() {
        // get verification record
        $attributes = array('call_sid' => Yii::app()->request->getPost('CallSid'));
        $verification = TwilioBusinessVerification::model()->findByAttributes($attributes);
        // change call_status
        $verification->call_status = yii::app()->request->getPost('CallStatus');
        $verification->save();
    }


    /**
     * Enters request to change the telephone number of an existing business.
     *
     * @param <none> <none>
     * @return <none> <none>
     */
    public function actionReportbusinessphone()
    {

        $businessId     = Yii::app()->request->getPost('businessId', 0);
        $newTelephone   = Yii::app()->request->getPost('telephone', '');

        $businessModel  = Business::model()->findByPk((int) $businessId);

        if ($businessModel === null)
        {
            throw new CHttpException(404,'The requested business does not exist.');
        }

        $systemNotificationModel                = new SystemNotification;
        $systemNotificationModel->entity_type   = 'business';
        $systemNotificationModel->entity_id     = $businessId;
        $systemNotificationModel->title         = 'Reported: Business Telephone Change : '.
            $businessModel->business_name;

        $userFullname                           = Yii::app()->user->getFullName();
        $timeNow                                = date("F j, Y, g:i a");    // March 10, 2014, 5:16 pm

        $noticeDescription = <<<EOD

Reported: Business Telephone Change : {$businessModel->business_name}

A report for changed telephone details has been issued for the above business

Old telephone  : {$businessModel->business_phone} {$businessModel->business_phone_ext}
New telephone  : {$newTelephone}

Issued by      : {$userFullname}
Time of Report : {$timeNow}

EOD;

        $systemNotificationModel->description   = $noticeDescription;
        $systemNotificationModel->status        = 'new';

        if ($systemNotificationModel->save() === false)
        {
            Yii::app()->user->setFlash('error', "Your request could not be processed at this time.");
            $this->redirect(array('/businessuser/profile/show', 'id' => $businessId));
        }

        Yii::app()->user->setFlash('success', "Thank you. The business has been reported for further processing.");

    }

    /**
     * Provide a summary of coupon activity for the current business.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     */
    private function getCouponSummary($businessId = null)
    {

        $summaryResults = array();

        /**
         * If a business id is not supplied, then supply the coupon details for all
         * ...businesses managed by this user.
        */

        if ($businessId === null)
        {
            // lists certificates of all business of the current user
            $inDdbCriteria              = new CDbCriteria();
            $inDdbCriteria->with        = array('businessUsers');
            $inDdbCriteria->condition   = "businessUsers.user_id = :user_id";
            $inDdbCriteria->params      = array(':user_id' => Yii::app()->user->id);

            $businessList               = Business::model()->findAll($inDdbCriteria);
            $businessIds                = array();

            foreach ($businessList as $businessItem)
            {
                array_push($businessIds, $businessItem['business_id']);
            }
        }
        else
        {

            /*
             * Push the filtered business into the business list.
            */

            $businessIds                = array();
            array_push($businessIds, $businessId);
        }


        $dbCriteria                 = new CDbCriteria();
        $dbCriteria->addInCondition('business_id', $businessIds);

        $lstAllMyCoupons            = Coupon::model()->findAll($dbCriteria);

        $summaryResults             = array('countAll'          => 0,
                                            'countPrinted'      => 0,
                                            'valuePrinted'      => 0);

        foreach ($lstAllMyCoupons as $itemCoupon)
        {
            $countPrinted                   = ($itemCoupon->count_created - $itemCoupon->count_available);

            $summaryResults['countAll']     += $itemCoupon->count_created;

            $summaryResults['countPrinted'] += $countPrinted;
            $summaryResults['valuePrinted'] += $countPrinted * $itemCoupon->coupon_value;

        }

        return $summaryResults;

    }

    /**
     * Provide a summary of coupon activity for the current business.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     */
    private function getBannerTop5($businessId = null)
    {

        /**
         * If a business id is not supplied, then supply the coupon details for all
         * ...businesses managed by this user.
        */

        if ($businessId === null)
        {
            // lists certificates of all business of the current user
            $inDdbCriteria              = new CDbCriteria();
            $inDdbCriteria->with        = array('businessUsers');
            $inDdbCriteria->condition   = "businessUsers.user_id = :user_id";
            $inDdbCriteria->params      = array(':user_id' => Yii::app()->user->id);

            $businessList               = Business::model()->findAll($inDdbCriteria);
            $businessIds                = array();

            foreach ($businessList as $businessItem)
            {
                array_push($businessIds, $businessItem['business_id']);
            }
        }
        else
        {

            /*
             * Push the filtered business into the business list.
            */

            $businessIds                = array();
            array_push($businessIds, $businessId);
        }

        $lstBanners = Yii::app()->db->createCommand()
                                    ->select('banner_id, banner_title')
                                    ->from('tbl_banner')
                                    ->where(array('in', 'business_id', $businessIds))
                                    ->limit('5')
                                    ->order('created_time DESC')
                                    ->queryAll();

        return $lstBanners;

    }


}