<?php
//ConciergeToorbar.php
/*
 * Usage :
 * $this->widget('application.components.ConciergeToolbar', array(
  'crumbs' => array(
    array('name' => 'Home', 'url' => array('site/index')),
    array('name' => 'Login'),
  ),
  'delimiter' => ' &rarr; ', // if you want to change it
));
 */
class ConciergeToolbar extends CWidget {



    public function run() {

        // Get the top 10 popular activity types
        $searchCriteria = new CDbCriteria();
        $searchCriteria->order      = 'search_count';
        $searchCriteria->limit      = 10;
        $searchCriteria->condition  = 'search_origin = "concierge" AND search_tag_type = "activity" ';

        $listActivitySearch = SearchLogSummary::model()->findAll($searchCriteria);

        // Get the top 10 popular categories
        $searchCriteria = new CDbCriteria();
        $searchCriteria->order      = 'search_count';
        $searchCriteria->limit      = 10;
        $searchCriteria->condition  = 'search_origin = "concierge" AND search_tag_type = "activity" ';

        $listCategorySearch = SearchLogSummary::model()->findAll($searchCriteria);

        // Get the top 10 popular categories
        $searchCriteria = new CDbCriteria();
        $searchCriteria->order      = 'search_count';
        $searchCriteria->limit      = 10;
        $searchCriteria->condition  = 'search_origin = "concierge" AND search_tag_type = "city" ';

        $listCitySearch = SearchLogSummary::model()->findAll($searchCriteria);



        $this->render('concierge_toolbar', array(   'listActivitySearch'    => $listActivitySearch,
                                                    'listCategorySearch'    => $listCategorySearch,
                                                    'listCitySearch'        => $listCitySearch
                                                ));
    }

    /**
     * Provide a list of actions that will be handled by the widget
     *
     * To use this, set controller’s actions() function to point to
     * ...the actions provider.
     * ...   // in Controller
     *       public function actions()
     *       {
     *          return array(
     *              // Point to the location where the handler class is
     *              'ctoolbar.'=>'application.components.WidgetClass',
     *          );
     *       }
     * ...In this case, 'ctoolbar.' (note the '.') is the prefix to use on
     * ...the URL for all actions within the ConciergeToolbar class
     *
     * ...We can call all the ConciergeToolbar actions as
     * ...  controllerID/actionPrefix.actionID.
     * ...In our case, for example
     * ...  index.php?r=site/ctoolbar.getActivity
     *
     * @param <none> <none>
     *
     * @return array list of actions and the route to the runnable action.
     * @access public
     */
    public static function actions(){
        return array(
            // naming the action and pointing to the location
            // where the external action class is
            'GetActivity'       =>'application.components.ConciergeToolbar.getActivity',
            'GetActivitytype'   =>'application.components.ConciergeToolbar.getActivityType',
        );
    }

    /**
     * Render the activity screen
     *
     * For now, this is performed by the class run() function
     *
     * @param <none> <none>
     *
     * @return array list of actions and the route to the runnable action.
     * @access public
     */
    public function getActivity()
    {
        ;
    }

    /**
     * Render the activity screen
     *
     * For now, this is performed by the class run() function
     *
     * @param <none> <none>
     *
     * @return array list of actions and the route to the runnable action.
     * @access public
     */
    public function getActivityType($listCategorySearch)
    {

        return $this->renderPartial('application.components.views.concierge_toolbar_activitytype',
                             array('listCategorySearch'    => $listCategorySearch),
                             true
                     );
    }

}