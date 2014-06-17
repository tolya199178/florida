<?php

/**
 * Calendar Controller interface for the Frontend (Public) Events Module
 */


/**
 * CalendarController is a class to provide access to controller actions for
 * ...general processing of user events. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/calendar/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/calendar/event/details/venue/tomsgarden/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. calendar/event/details/venue/tomsgarden/ will invoke CalendarController::actionDetails()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /calendar/event/details/venue/tomsgarden/ will pass $_GET['venue'] = 'tomsgarden'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class CalendarController extends Controller
{

    public 	$layout='//layouts/front';


    /**
     * Default controller action.
     * Shows an events 'dashboard'
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{


        CController::forward('/calendar/calendar/browse/');


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
	    // Get a listing of calendar for the current category
	    // /////////////////////////////////////////////////////////////////////
	    $dbCriteria             = new CDbCriteria;
	    $dbCriteria->with       = array('eventCategory');
	    $dbCriteria->limit      = (int) Yii::app()->params['PAGESIZEREC'];
	    $dbCriteria->offset     = $argPage * $dbCriteria->limit;

	    // NOTE: Add this otherwise Yii removes the relation from the query.
	    // https://code.google.com/p/yii/issues/detail?id=2678
	    $dbCriteria->together   = true;

	    $dbCriteria->condition  = 'eventCategory.category_id = :category_id';

	    if (empty($currentCategory))
	    {
	        $dbCriteria->addCondition('eventCategory.category_id IS NULL', 'OR');
	    }

	    $dbCriteria->params     = array(':category_id' => $currentCategory);

	    $listEvents   = Event::model()->findAll($dbCriteria);

	    $this->renderPartial('event_list', array('listEvents' => $listEvents));

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
                                    	    ->from('tbl_event_category');

	    if (empty($currentCategory))
	    {
	        $cmdSubCategoryList->where('parent_id = 0 OR parent_id  IS NULL', array(':category_id'=>$currentCategory));
	    }
	    else
	    {
	        $cmdSubCategoryList->where('parent_id = :category_id', array(':category_id'=>$currentCategory));
	    }

	    $listSubcategory = $cmdSubCategoryList->queryAll();

	    // /////////////////////////////////////////////////////////////////////
	    // Get a few upcoming events
	    // /////////////////////////////////////////////////////////////////////
	    $dbCriteria             = new CDbCriteria;
	    $dbCriteria->limit      = 5;
	    $dbCriteria->order      = 'event_start_date DESC';
	    $listUpcomingEvents     = Event::model()->findAll($dbCriteria);

	    $this->render('browse', array('category_path'      => $categoryBreadcrumb,
                        	          'listSubcategories'  => $listSubcategory,
                        	          'currentCategory'    => $currentCategory,
	                                  'listUpcomingEvents' => $listUpcomingEvents
	    ));
	}

	/**
	 * Displays the business listing screen
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionShowevent()
	{

	    $argEventId = (int) Yii::app()->request->getQuery('event', 0);

	    if ($argEventId == 0)
	    {
	        throw new CHttpException(404,'The requested page does not exist.');
	    }


	    $itemEvent     = Event::model()->findByPk($argEventId);

	    $this->render('event_details', array('event' => $itemEvent));
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
	        ->from('tbl_event_category')
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
	 * Creates a new event record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the event details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Event record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Event validation (Event::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionNewevent()
	{

	    $eventModel = new Event;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($eventModel);

	    if(isset($_POST['Event']))
	    {

	        $eventModel->attributes=$_POST['Event'];

	        $uploadedFile = CUploadedFile::getInstance($eventModel,'fldUploadImage');

	        if($eventModel->save())
	        {

	            if(!empty($uploadedFile))  // check if uploaded file is set or not
	            {

	                $imageFileName = 'event-'.$eventModel->event_id.'-'.$uploadedFile->name;
	                $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;

	                $uploadedFile->saveAs($imagePath);
	                $eventModel->event_photo = $imageFileName;

	                $this->createThumbnail($imageFileName);

	                $eventModel->save();
	            }

	            $this->redirect(array('index'));

	        }
	        else {
	            Yii::app()->user->setFlash('error', "Error creating a event record.'");
	        }


	    }

	    // Show the details screen
	    $this->renderPartial('create_event_form',array('model'=>$eventModel), false, true);

	}

}