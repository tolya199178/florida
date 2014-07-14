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
        $myCertificateSummary                       = $this->getCertificateSummary($argCurrentBusiness);



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
                               'myCertificateSummary' => $myCertificateSummary);


        $this->render('dashboard/dashboard_main', array('config'=>$configDashboard, 'data'=>$dashboardData));

    }


}