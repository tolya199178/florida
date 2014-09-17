<?php

/**
 * Login portlet to render a login form
 * ...tables.
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * This component class extends the CPortlet and displays a login form.
 *
 * Typical usage is from a view, for example
 *   if(Yii::app()->user->isGuest) {$this->widget('UserLogin', array('param1' => 'value1'));}
 *
 * @package Components
 * @version 1.0
 */


Yii::import('zii.widgets.CPortlet');
class UserLogin extends CPortlet
{

	protected function renderContent()
	{

        $form=new LoginForm;
        $this->render('embedded_login',array('form'=>$form));
        $this->render('modal_login',array('form'=>$form));

	}
}
