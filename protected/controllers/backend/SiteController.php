<?php

// class SiteController extends Controller
class SiteController extends BackEndController
{


	public 	$layout='//layouts/page';

	public $menu_node = 'home';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		// $this->redirect( array('dashboard') );
		$this->actionDashboard();

	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				// $this->render('error', $error);
				$this->render( 'error', array( 'error' => $error ) );
		}
	}


	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{


			// $model = new LoginForm;
	    $model = new LoginForm;
	    
	    // print_r($_POST);
		
			// if it is ajax validation request
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
			{
				$errors = CActiveForm::validate($model);
				if ($errors != '[]')
				{
					echo $errors;
					Yii::app()->end();
				}
			}
		
			// collect user input data
			if (isset($_POST['LoginForm']))
			{
				$model->attributes = $_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if ($model->validate() && $model->login())
				{
					if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
					{
						echo CJSON::encode(array(
								'authenticated' => true,
								'redirectUrl' => Yii::app()->user->returnUrl,
								"param" => "Any additional param"
						));
						Yii::app()->end();
					}
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->layout='//layouts/blank';
				
			$this->render('login', array('model' => $model));
		
		
	}

	/**
	 * Displays the login page
	 */
	public function actionMailinglist()
	{

		// collect user input data
		if(isset($_POST['ManageAccount']))
		{

			if (!empty($_POST['ManageAccount']['unsubscribe'])) {

				$email 				= $_POST['ManageAccount']['email'];

				$user_model 		= MaillistUser::model()->findByAttributes(array('email' => "$email"));


				if ($user_model == null) {
					echo "Noooo!";

					$this->render('register/not_validated');

				}
				else {

					$user_model->validated				= 'N';
					$user_model->validation_code		= '';
					$user_model->active					= 'N';
					$user_model->subscription_status	= 'Unsubscribed';

					//$model->details_updated				= date('Y-m-d H:i:s');
					$model->unsubscribe_date			= date('Y-m-d H:i:s');

					$user_model->save();

					$this->render('register/unsubscribed');


					// /////////////////////////////////////////////////////////////////
					// Send the new registratrant a free gift
					// /////////////////////////////////////////////////////////////////

					$to_email_address 			= Yii::app()->request->getPost('email');
					$to_name					= Yii::app()->request->getPost('name');
					$from_email_adddress 		= 'online@datacraft.co.za';
					$area						= Yii::app()->request->getPost('area');
					$msg						= Yii::app()->request->getPost('message');

					$headers = array(
											'MIME-Version: 1.0',
											'Content-type: text/html; charset=iso-8859-1'
					);

					$from_email_adddress  	=  'Datacraft Inquiry Service <'.$from_email_adddress.'>';
					$to_email_address		=  $to_name.' <'.$to_email_address.'>';

					// Send validation email
					$data 					=  array();
					$data['name']			=  $to_name;

					$message				=  $this->renderPartial('register/unsubscribed_email',$data, true);

					echo $message;

					Yii::app()->email->send($from_email_adddress, $to_email_address, 'Thank you for your subscription', $message, $headers);

					// Send 'CC'
					$message = "Datacraft Web Inquiry
											Received from $from_email_adddress
											Area of Focus : $area
											Message : $msg";
					Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: Thank you for your subscription', $message, $headers);


				}




			}
			else if (!empty($_POST['ManageAccount']['update'])) {
				echo 'Not supported yet.';
			}
			else if (!empty($_POST['ManageAccount']['register'])) {
				echo 'Not supported yet.';
			}

			exit;
		}
		else {

			$page = 'site/backend/manage_list';

			$this->render($page);

		}


 	}

	
	/**
	 *  Handle document request. Create an entry for the user in the mailing list of they don't exist
	 *  ...already, and add them to a document request queue to track requests and loads/
	 */
	public function actionSendmail()
	{

		$model = new SendmailForm;
	
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// collect user input data
		if(isset($_POST['SendmailForm']))
		{

			// echo CActiveForm::validate($model);
			
			// /////////////////////////////////////////////////////////////////
			// Get the user input from the submitted form.
			// /////////////////////////////////////////////////////////////////
			$form_input 				= Yii::app()->request->getPost('SendmailForm');
			
			//if (isset($form_input['email_list'])) {
			//	$email_list = explode("\n", $form_input['email_list']);
			//}
			if (isset($form_input['subject'])) {
				$subject = $form_input['subject'];
			}
			if (isset($form_input['sendfrom'])) {
				$sendfrom = $form_input['sendfrom'];
			}
			if (isset($form_input['message'])) {
				$message = $form_input['message'];
			}
			
			if (empty($sendfrom)) {
				$sendfrom = 'Datacraft Online <online@datacraft.co.za>';
			}
			
			
			// $contact_models = MaillistUser::model()->findAllByPk($form_input['email_list']);
			$contact_models = MaillistUser::model()->findAllByAttributes(array('email' => $form_input['email_list']));
	
			$headers = array(
							'MIME-Version: 1.0',
							'Content-type: text/html; charset=iso-8859-1'
			);
				

			foreach ($contact_models as $contact) {
				
				$personalisation_tag 		= array();
				$personalisation_value 		= array();
				
				// find the email address on the address book. Only matches will be sent!
				
				$personalisation_tag[] = '{fullname}';  $personalisation_value[] = $contact['fullname'];
				$personalisation_tag[] = '{firstname}'; $personalisation_value[] = $contact['firstname'];
				$personalisation_tag[] = '{surname}';   $personalisation_value[] = $contact['surname'];
				$personalisation_tag[] = '{email}'; 	$personalisation_value[] = $contact['email'];
				$personalisation_tag[] = '{company}'; 	$personalisation_value[] = $contact['company'];
				$personalisation_tag[] = '{position}'; 	$personalisation_value[] = $contact['position'];
				$personalisation_tag[] = '{title}'; 	$personalisation_value[] = $contact['title'];
				$personalisation_tag[] = '{date}'; 		$personalisation_value[] = date('Y-m-d');
				
				// Provides: <body text='black'>				
				
				$personalised_message = str_replace($personalisation_tag, $personalisation_value, $message);
				$personalised_subject = str_replace($personalisation_tag, $personalisation_value, $subject);
				
				$sendto = $contact['fullname'].'<'.$contact['email'].'>';
				
 				Yii::app()->email->send($sendfrom, $sendto, $personalised_subject, $personalised_message, $headers);
 				
 				// Log the message
 				$log_model = new MailLog;
 				$log_model->recipient	= $sendto;
 				$log_model->send_date 	= date('Y-m-d H:i:s');
 				$log_model->sender 		= $sendfrom;
 				$log_model->subject   	= $personalised_subject;
 				$log_model->message   	= $personalised_message;

 				if(!$log_model->save())
 					throw new CHttpException(405,'There was a problem saving the email log record.');
 				
 				sleep(5);

			}

			$this->actionDashboard();

			Yii::app()->end();

		}
		else {
			
			$this->render('/site/sendmail', array('model' => $model));				
			
		}
	
	}

	/**
	 * Displays the dashboard
	 */
	public function actionDashboard()
	{
		$this->render('/site/dashboard');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}