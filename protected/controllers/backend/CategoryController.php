<?php

/**
 * Controller interface for Category management.
 */

/**
 * Category Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/category/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/category/edit/category_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /category/edit/category_id/99/ will invoke CategoryController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /category/edit/category_id/99/ will pass $_GET['category_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class CategoryController extends BackEndController
{


    /**
     * Specify a list of filters to apply to action requests
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
     */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Override CController access rules and provide base rules for derived class.
	 * All derived classes will automatically inherit the access rules provided.
	 *
	 * @param <none> <none>
	 *
	 * @return array list of accessrules to apply
	 * @access public
	 */
	/*
	 * TODO: Convert this to use RBAC
	 */
    public function accessRules()
    {

        return array(
            // Admin has full access. Applies to all controller action.
            array(
                'allow',
                'expression' =>'Yii::app()->user->isSuperAdmin()',
               // 'actions'    =>array('create'),

            ),

            // delegate to category model methods to determine ownership
            array(
                'allow',
                'expression' =>'true',
                'actions'    =>array('edit'),
            ),

            // delegate to category model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


	/**
	 * Creates a new category record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the category details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Category record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Category validation (Category::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{

		$categoryModel = new Category;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($categoryModel);

	    if(isset($_POST['Category']))
	    {

	        $categoryModel->attributes=$_POST['Category'];

	        if($categoryModel->save())
	        {
	            $this->redirect(array('index'));
	        }
	        else
	        {
                Yii::app()->user->setFlash('error', "Error creating a category record.");
	        }

	    }


	    // Show the details screen
	    $this->render('details',array('model'=>$categoryModel));

	}


	/**
	 * Updates an existing category record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested category's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Category record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Category validation (Category::rules())
	 *
	 * @param integer $category_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($category_id)
	{

		$categoryModel = Category::model()->findByPk((int)$category_id);
		if($categoryModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($categoryModel);

		if(isset($_POST['Category']))
		{
            // Assign all fields from the form
		    $categoryModel->attributes=$_POST['Category'];

		    if($categoryModel->save())
		    {

		        $this->redirect(array('index'));

		    }
		    else
		    {
		        Yii::app()->user->setFlash('error', "Error creating a category record.'");
		    }

		}

	    $this->render('details',array('model'=> $categoryModel));
	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by category
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all categorys.
	    $this->redirect(array('list'));
	}

	/**
	 * Show all events. Renders the event listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('Category');
	    $this->render('list', array(
	        'dataProvider'=>$dataProvider,
	    ));
	}


	/**
	 * Generates a JSON encoded list of all categorys.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 *
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or category bahaviour.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionListjson() {

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        // Paging criteria
        // Set defaults
        $limitStart 	           = isset($_POST['start'])?(int)$_POST['start']:0;
        $limitItems 	           = isset($_POST['length'])?(int)$_POST['length']:Yii::app()->params['PAGESIZEREC'];

        $searchCriteria->limit 		 = $limitItems;
        $searchCriteria->offset 	 = $limitStart;

         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
         {
             $searchCriteria->addSearchCondition('t.category_name', $_POST['search']['value'], true);
         }


        $lstCategory    = Category::model()->findAll($searchCriteria);

        $countRows 		= Category::model()->count($searchCriteria);;
        $totalRecords 		= Category::model()->count();

        /*
         * Output
         */
        $jsonOutput = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $totalRecords,
            "aaData"                => array()
        );

        foreach($lstCategory as $recTemplate){

            $recRow = array( $recTemplate->attributes['category_id'],
                             $recTemplate->attributes['category_name'],
                             $recTemplate->attributes['category_description'],
                         ''
                        );
            $jsonOutput['aaData'][] = $recRow;

        }


        echo json_encode($jsonOutput);


	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Category $categoryModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($categoryModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($categoryModel);
			Yii::app()->end();
		}
	}


}
