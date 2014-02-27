<?php

/**
 * Backend Base Controller
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * BackEndController is the customized base controller class
 *
 * Base controller class for all application controller classes.
 * Application controllers must extend this class :
 * class SomeClass extends BackEndController
 *
 * @package Components
 * @version 1.0
 */
class BackEndController extends CController
{

    /**
     * 
     * @var string layout specified the page to be rendered
     * @access public
     */
    public $layout = '//layouts/page';
        
    // Not used
    //     public $menu=array();
    //     public $breadcrumbs=array();
    
    
    /**
     * Override CController filters and provide base filters for derived class.
     * All derived classes will automatically inherit the filters provided.
     *
     * @param <none> <none>
     *            
     * @return array list of filters to apply
     * @access public
     */
    public function filters()
    {
        // All backend classes must be subjected to access control rules
        return array(
            'accessControl'
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
    public function accessRules()
    {
        return array(
            // Allow all users the login method, so that they are not locked out.
            array(
                'allow',
                'users' => array(
                    '*'
                ),
                'actions' => array(
                    'login'
                )
            ),
            // All actions requires authentication.
            array(
                'allow',
                'users' => array(
                    '@'
                )
            ),
            // No one else gets access to any actions
            array(
                'deny',
                'users' => array(
                    '*'
                )
            )
        );
    }
}