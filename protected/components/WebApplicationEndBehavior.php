<?php

/**
 * Behaviour to support separate frontend and backend application layout
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * This component changes the behavior and forces Yii to search controllers and
 * ...views in the “backend” or “public” subdirectories depending on the
 * ...currently running end.
 *
 * @package Components
 * @version 1.0
 */
class WebApplicationEndBehavior extends CBehavior
{

    /**
     *
     * @var string Web application's end requested
     * @access private
     *        
     */
    private $_endName;

    /**
     * Getter to fetch the current -end's name
     *
     * Usage:
     * Yii::app()->endName;
     *
     * @param <none> <none>
     *            
     * @return string current application end
     * @access public
     */
    public function getEndName()
    {
        return $this->_endName;
    }
    
    /**
     * Getter to set the current -end's name
     *
     * @param string $name current run application end
     *            
     * @return <none>
     * @access public
     */
    public function runEnd($name)
    {
        // Set the end name
        $this->_endName = $name;
        
        // Attach the changeModulePaths event handler and raise the event.
        $this->onModuleCreate = array($this, 'changeModulePaths');
        $this->onModuleCreate(new CEvent($this->owner));
        
        $this->owner->run(); // Run application.
    }
    
    /**
     * This event should be raised when CWebApplication or CWebModule instances
     * ...are being initialized.
     *
     * @param CEvent $event the event raised
     *
     * @return <none>
     * @access public
     */
    public function onModuleCreate($event)
    {
        $this->raiseEvent('onModuleCreate', $event);
    }
    

    /**
     * onModuleCreate event handler.
     * A sender must have controllerPath and viewPath properties.
     *
     * @param CEvent $event the event raised
     *
     * @return <none>
     * @access public
     */
    protected function changeModulePaths($event)
    {
        // Set the controller path
        $event->sender->controllerPath .= DIRECTORY_SEPARATOR . $this->_endName;
        
        // Set the view path. Manage situation if view is used
        if ($event->sender->theme !== null)
        {
            $event->sender->viewPath = $event->sender->theme->basePath . DIRECTORY_SEPARATOR .
                                       'views' . DIRECTORY_SEPARATOR . $this->_endName;
        }
        else
        {
            $event->sender->viewPath .= DIRECTORY_SEPARATOR . $this->_endName;
        }
    }
}
