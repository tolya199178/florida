<?php
/**
 * Base Controller
 * 
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * Controller is the customized base controller class
 *
 * Base controller class for all application controller classes.
 * Application controllers must extend this class :
 * class SomeClass extends Controller
 * 
 * @package Components
 * @version 1.0
 */
class Controller extends CController
{

    /**
     * @var string the default layout for the controller view.
     * @access public
     * 
     *      Defaults to '//layouts/column1'.
     *      See 'protected|themes/views/layouts/column1.php'
     */
    public $layout = '//layouts/page';
    
    /**
     *
     * @var array context menu items.
     * @access public
     * 
     * This property will be assigned to {@link CMenu::items}.
     * 
     */
    public $menu = array();

    /**
     *
     * @var array the breadcrumbs of the current page.
     * @access public
     * 
     * The value of this property will be assigned to {@link CBreadcrumbs::links}.
     * 
     */
    public $breadcrumbs = array();
}