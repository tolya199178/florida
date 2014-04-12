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

}