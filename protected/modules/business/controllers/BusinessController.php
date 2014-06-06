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
  //      echo 'hello';
        // exit;
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
	public function actionBrowse()
	{

	    $argCategoryId = (int) Yii::app()->request->getQuery('category', 0);



	    // TODO: For now, we display from the root. In next iterations, we will add
	    // TODO: paging and category filtering.
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

//         $listSubcategory = Yii::app()->db->createCommand()
//                                          ->select('category_id, parent_id, category_name')
//                                          ->from('tbl_category')
//                                  	     ->where('parent_id = :category_id', array(':category_id'=>$currentCategory))
//                                 	     ->queryAll();


        // /////////////////////////////////////////////////////////////////////
        // Get a listing of businesses for the current category
        // /////////////////////////////////////////////////////////////////////
        $dbCriteria             = new CDbCriteria;
        $dbCriteria->with       = array('businessCategories');
        $dbCriteria->limit      = Yii::app()->params['PAGESIZEREC'];

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


        $this->render('browse', array('category_path'     => $categoryBreadcrumb,
                                      'listSubcategories' => $listSubcategory,
                                      'listBusiness'      => $listBusiness
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
}