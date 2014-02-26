<?php

class SiteController extends Controller
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

		$this->menu_node = 'home';

		$this->render('/site/home', array('show_banner' => true));
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionServices($service)
	{
		echo 'hello';

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('/site/services/' . $service);
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
 	 * Displays the contact page
 	 */
 	public function actionContact()
 	{
 		$model=new ContactForm;
//  		if(isset($_POST['ContactForm']))
//  		{
//  			$model->attributes=$_POST['ContactForm'];
//  			if($model->validate())
//  			{
//  				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
//  				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
//  				$headers="From: $name <{$model->email}>\r\n".
//  					"Reply-To: {$model->email}\r\n".
//  					"MIME-Version: 1.0\r\n".
//  					"Content-type: text/plain; charset=UTF-8";

//  				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
//  				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
//  				$this->refresh();
//  			}
//  		}
 		$this->menu_node = 'contact';
 		$this->render('contact',array('model'=>$model));
 	}

	public function actionRender()
	{
		$page = Yii::app()->request->getQuery('page',null);

		$this->render($page);
	}

	public function actionSolutions()
	{
		$type = Yii::app()->request->getQuery('type',null);

		$this->menu_node = $type;
		$this->render('/site/solutions/solutions4'.$type);
	}

	public function actionJoinlist() {
		
		if ( count($_POST) == 0) {
			$this->redirect(Yii::app()->homeUrl);
		}
		
		// TODO: If record is already on list, then update details. Search by email.

		$to_email_address 			= Yii::app()->request->getPost('email');
		$to_name					= Yii::app()->request->getPost('name');
		$from_email_adddress 		= 'online@datacraft.co.za';
		$area						= Yii::app()->request->getPost('area');

		$email_encrypt 				= urlencode($to_email_address);
		$special_string 			= 'datacraft?'.time();
		$hash = md5($email_encrypt.$special_string);

		$model						= new MaillistUser;
		$model->validated			= 'N';
		$model->validation_code		= $hash;
		$model->fullname			= $to_name;
		$model->email				= $to_email_address;
		$model->area				= $area;
		$model->active				= 'N';
		$model->details_updated		= date('Y-m-d H:i:s');
		$model->subscribe_date		= date('Y-m-d H:i:s');

		$model->save();

		$errors = $model->getErrors();

		if (count($errors) > 0) {
			echo "here";

			$model->addError(100, "Added Error");


			$error_message = '<ul>';
			foreach ($errors as $field => $messages) {
				//print_r($messages);

				foreach ($messages as $message) {
					$error_message .= '<li>' . $field . ' : ' . $message . '</li>';
					// print_r($message);

				}
			}
			$error_message .= '</ul>';

			throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
		}
		
		$headers = array(
				'MIME-Version: 1.0',
				'Content-type: text/html; charset=iso-8859-1'
		);

		$from_email_adddress  	=  'Datacraft Online <'.$from_email_adddress.'>';
		$to_email_address		=  $to_name.' <'.$to_email_address.'>';

		// Send validation email
		$data 					=  array();
		$data['hash']			=  $hash;
		$data['name']			=  $to_name;

		if ($area == 'online_strategy') {
			$message				=  $this->renderPartial('programme/online_strategy/welcome_email',$data, true);
			$subject				= 'Thank you for registering for the Online Strategy programme';
			$welcome_page			= 'programme/online_strategy/welcome';
		}
		else {
			$message				=  $this->renderPartial('register/welcome_email',$data, true);
			$subject				= 'Thank you for your subscription';
			$welcome_page			= 'register/welcome';
		}
		


		// echo $message;

		Yii::app()->email->send($from_email_adddress, $to_email_address, $subject, $message, $headers);
		// Send 'CC'
		Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: '.$subject, $message, $headers);


		$this->render($welcome_page);

	}

	public function actionContactus() {
		
		if (count($_POST) == 0) {
			Yii::app()->end();
		}

		$to_email 					= Yii::app()->request->getPost('email');
		$to_name					= Yii::app()->request->getPost('name');
		$phone						= Yii::app()->request->getPost('phone');
		$from_email_adddress 		= 'online@datacraft.co.za';
		$area						= Yii::app()->request->getPost('area');
		$msg						= Yii::app()->request->getPost('message');

		$headers = array(
				'MIME-Version: 1.0',
				'Content-type: text/html; charset=iso-8859-1'
		);

		$from_email_adddress  	=  'Datacraft Online <'.$from_email_adddress.'>';
		$to_email_address		=  $to_name.' <'.$to_email.'>';

		// Send validation email
		$data 					=  array();
		$data['name']			=  $to_name;

		$message				=  $this->renderPartial('register/inquiry_thank_you',$data, true);

		Yii::app()->email->send($from_email_adddress, $to_email_address, 'Thank you for your enquiry', $message, $headers);

		// Send 'CC'
		$message = "Datacraft Web Inquiry<br/>
				Received from $to_name (Email : $to_email)<br/>
				Telephone $phone<br/>
				Area of Focus : $area<br/>
				Message : $msg<br/>";
		Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: Thank you for your enquiry', $message, $headers);


		echo "Thank you for your inquiry. A consultant will be contacting you soon.";

		// $this->render("register/welcome");

	}

	function actionValidate() {

		$hash 							= Yii::app()->request->getQuery('cde');

		//echo $hash;

		$user_model 					= MaillistUser::model()->findByAttributes(array('validation_code' => "$hash"));

		// print_r($user_model);

		if ($user_model == null) {
			// echo "Noooo!";

			$this->render('register/not_validated');

		}
		else {

			$user_model->validated				= 'Y';
			// $user_model->validation_code		= '';
			$user_model->active					= 'Y';
			$user_model->subscription_status	= 'Subscribed';

			// $model->details_updated		= date('Y-m-d H:i:s');
			// $user_model->subscribe_date		= date('Y-m-d H:i:s');

			$user_model->save();
			
			$to_email_address 			= $user_model->email;
			$to_name					= $user_model->fullname;
			$from_email_adddress 		= 'online@datacraft.co.za';
			$area						= $user_model->area;
			//$msg						= Yii::app()->request->getPost('message');
			
			$data 						= null;
			
			if ($area == 'online_strategy') {
				$page 					= 'programme/online_strategy/validated';
				$message				=  $this->renderPartial('programme/online_strategy/validated_email',$data, true);
				$subject				= 'Thank you for joining the Online Stategy programme.';
			}
			else {
				$page 					= 'register/validated';
				$message				=  $this->renderPartial('register/validated_email',$data, true);
				$subject				= 'Thank you for your subscription';
			}
			
			$this->render($page);

			// /////////////////////////////////////////////////////////////////
			// Send the new registratrant a free gift
			// /////////////////////////////////////////////////////////////////

			
			
			$headers = array(
							'MIME-Version: 1.0',
							'Content-type: text/html; charset=iso-8859-1'
			);

			$from_email_adddress  	=  'Datacraft Online <'.$from_email_adddress.'>';
			$to_email_address		=  $to_name.' <'.$to_email_address.'>';

			// Send validation email
			$data 					=  array();
			$data['name']			=  $to_name;


			// echo $message;

			Yii::app()->email->send($from_email_adddress, $to_email_address, $subject, $message, $headers);

			// Send 'CC'
			$message = "Datacraft Web Inquiry
							Received from $from_email_adddress
							Area of Focus : $area
							Message : $message";
			Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY:'.$subject, $message, $headers);


		}




	}


	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionManage_account()
	{

		// collect user input data
		if(isset($_POST['ManageAccount']))
		{
			
			if ($_POST['ManageAccount']['email'] == null) {
				throw new CHttpException(405,'Cannot process the data you submitted. Sorry.<br>' );
			}
			

			if (!empty($_POST['ManageAccount']['unsubscribe'])) {
				


				$email 				= $_POST['ManageAccount']['email'];

				$user_model 		= MaillistUser::model()->findByAttributes(array('email' => "$email"));

				// print_r($user_model);

				if ($user_model == null) {

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
					
					$subsriber_details = Yii::app()->request->getPost('ManageAccount');
					
					$to_email_address 			= $subsriber_details['email'];
					$to_name					= $subsriber_details['full_name'];
					$from_email_adddress 		= 'online@datacraft.co.za';
					// $area						= Yii::app()->request->getPost('area');
					// $msg						= Yii::app()->request->getPost('message');
					

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

					// echo $message;

					Yii::app()->email->send($from_email_adddress, $to_email_address, 'Thank you for your subscription', $message, $headers);

					// Send 'CC'
					$message = "Datacraft Web Inquiry<br/>
											Received from $from_email_adddress<br/>
											Sent to " . str_replace(array('<', '>'), array('(', ')'), $to_email_address) . "<br/>
											Message : $message";
					Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: Thank you for your subscription', $message, $headers);


				}




			}
			else if (!empty($_POST['ManageAccount']['subscribe'])) {


				if ( count($_POST) == 0) {
					$this->redirect(Yii::app()->homeUrl);
				}
				
				// TODO: If record is already on list, then update details. Search by email.
				
				$subsriber_details = Yii::app()->request->getPost('ManageAccount');
					
				$to_email_address 			= $subsriber_details['email'];
				$to_name					= $subsriber_details['full_name'];
				$from_email_adddress 		= 'online@datacraft.co.za';
				
				$email_encrypt 				= urlencode($to_email_address);
				$special_string 			= 'datacraft?'.time();
				$hash = md5($email_encrypt.$special_string);
				
				$model						= new MaillistUser;
				$model->validated			= 'N';
				$model->validation_code		= $hash;
				$model->fullname			= $to_name;
				$model->email				= $to_email_address;
				$model->area				= 'subscribe';
				$model->active				= 'N';
				$model->details_updated		= date('Y-m-d H:i:s');
				$model->subscribe_date		= date('Y-m-d H:i:s');
				
				$model->save();
				
				$errors = $model->getErrors();
				
				if (count($errors) > 0) {
				
					$model->addError(100, "Added Error");
				
				
					$error_message = '<ul>';
					foreach ($errors as $field => $messages) {
				
						foreach ($messages as $message) {
							$error_message .= '<li>' . $field . ' : ' . $message . '</li>';				
						}
					}
					$error_message .= '</ul>';
				
					throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
				}
				
				$headers = array(
						'MIME-Version: 1.0',
						'Content-type: text/html; charset=iso-8859-1'
				);
				
				$from_email_adddress  	=  'Datacraft Online <'.$from_email_adddress.'>';
				$to_email_address		=  $to_name.' <'.$to_email_address.'>';
				
				// Send validation email
				$data 					=  array();
				$data['hash']			=  $hash;
				$data['name']			=  $to_name;
				
				$message				=  $this->renderPartial('register/welcome_email',$data, true);
				$subject				= 'Thank you for your subscription';
				$welcome_page			= 'register/welcome';
				
				Yii::app()->email->send($from_email_adddress, $to_email_address, $subject, $message, $headers);
				// Send 'CC'
				Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: '.$subject, $message, $headers);
				
				
				$this->render($welcome_page);
			
						
			}
			else if (!empty($_POST['ManageAccount']['subscribe'])) {
				throw new CHttpException(405,'Action noy supported. Sorry.<br>' );
			}
			
			Yii::app()->end();

		}
		else {

			$page = 'register/manage_account';

			$this->render($page);

		}

	}

	/**
	*  Handle document request. Create an entry for the user in the mailing list of they don't exist
	*  ...already, and add them to a document request queue to track requests and loads/
	*/
	public function actionReqdoc()
	{

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		$doc = Yii::app()->request->getQuery('doc',null);

		
		if ($doc == 'project') {
			
			$this->getProjectDoc();
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ReqDoc']))
		{

			// /////////////////////////////////////////////////////////////////
			// Get the user input from the submitted form.
			// /////////////////////////////////////////////////////////////////
			$form_input 				= Yii::app()->request->getPost('ReqDoc');

			$requested_doc 				= $form_input['doc'];
			$to_email 					= $form_input['email'];
			$to_email_address 			= $form_input['email'];
			$to_name					= $form_input['name'];
			$area						= $form_input['area'];
			$msg						= $form_input['message'];
			$phone						= $form_input['phone'];

			$from_email_adddress 		= 'online@datacraft.co.za';

			$email_encrypt 				= urlencode($to_email_address);
			$special_string 			= 'datacraft?'.time();
			$hash 						= md5($email_encrypt.$special_string);

			// /////////////////////////////////////////////////////////////////
			// Find if the user is already on the mailing list. Add the user if
			// ...this is a new user.
			// /////////////////////////////////////////////////////////////////
			$user_model 		= MaillistUser::model()->findByAttributes(array('email' => $to_email_address));

			if ($user_model != null) {
				// Existing user. Don't do anything
				;

			}
			else {

				// /////////////////////////////////////////////////////////////////
				// New user. Add the user to the mailing list.
				// /////////////////////////////////////////////////////////////////

				$user_model						= new MaillistUser;
				$user_model->validated			= 'N';
				$user_model->validation_code	= $hash;
				$user_model->fullname			= $to_name;
				$user_model->email				= $to_email_address;
				$user_model->area 				= $area;
				$user_model->active				= 'N';
				$user_model->subscribe_date		= date('Y-m-d');
				$user_model->details_updated	= date('Y-m-d H:i:s');
				$user_model->subscribe_date		= date('Y-m-d H:i:s');


				$user_model->save();

				$errors = $user_model->getErrors();

				if (count($errors) > 0) {
					echo "here";

					$user_model->addError(100, "Added Error");


					$error_message = '<ul>';
					foreach ($errors as $field => $messages) {
						//print_r($messages);

						foreach ($messages as $message) {
							$error_message .= '<li>' . $field . ' : ' . $message . '</li>';
							// print_r($message);

						}
					}
					$error_message .= '</ul>';

					throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
				}

			}

			// /////////////////////////////////////////////////////////////////
			// Save the document request.
			// /////////////////////////////////////////////////////////////////

			$request_model 					= new DocumentRequest;
			$request_model->user_id			= $user_model->attributes['user_id'];
			$request_model->fullname 		= $to_name;
			$request_model->email    		= $to_email_address;
			$request_model->request_date 	= date('Y-m-d H:i:s');
			$request_model->request_code 	= $hash;
			$request_model->resource_name 	= 'whitepaper.open_source_for_business.pdf';

			$request_model->save();

			$errors = $request_model->getErrors();

			if (count($errors) > 0) {

				$request_model->addError(100, "Added Error");


				$error_message = '<ul>';
				foreach ($errors as $field => $messages) {
					//print_r($messages);

					foreach ($messages as $message) {
						$error_message .= '<li>' . $field . ' : ' . $message . '</li>';
						// print_r($message);

					}
				}
				$error_message .= '</ul>';

				throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
			}


			// /////////////////////////////////////////////////////////////////
			// Send the email with a thank you note and the link to requested
			// ..respurce.
			// /////////////////////////////////////////////////////////////////

			$headers = array(
							'MIME-Version: 1.0',
							'Content-type: text/html; charset=iso-8859-1'
			);



			$from_email_adddress  	=  'Datacraft Online <'.$from_email_adddress.'>';
			$to_email_address		=  $to_name.' <'.$to_email.'>';

			// Send validation email
			$data 						= array();
			$data['name']				= $to_name;
			
			if ($doc == 'osdoc') {
				$data['document_title']		= 'Open Source for Business Whitepaper';
			}
			else {
				$data['document_title']		= 'Your requested document';		// TODO: Remove hardcoding
			} 
			$data['hash']				= $hash;

			$message					=  $this->renderPartial('document_request_email',$data, true);

			Yii::app()->email->send($from_email_adddress, $to_email_address, 'Thank you for your enquiry', $message, $headers);

			// Send 'CC'
			$message = "Datacraft Web Inquiry<br/>
							Received from $to_name ( $to_email )<br/>
							Phone $phone)<br/>
							Comment $msg)<br/>
							Message : $message<br/>";
			Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: Thank you for your enquiry', $message, $headers);

			$this->render('resource_request_confirmed', $data);

			Yii::app()->end();

		}

		if ($doc == 'osdoc') {
			$this->render('download_doc', array('doc'=>'ospaper'));			
		}
		else {
			$this->redirect(Yii::app()->homeUrl);
		}



	}


	/**
	*  Handle document request. Create an entry for the user in the mailing list of they don't exist
	*  ...already, and add them to a document request queue to track requests and loads/
	*/
	public function actionGetdoc()
	{

		$hash 							= Yii::app()->request->getQuery('cde');

		$request_model 					= DocumentRequest::model()->findByAttributes(array('request_code' => "$hash"));

		if ($request_model == null) {

			$this->render('register/not_validated');

		}
		else {

			// Update the request record
			$request_model->collection_date = date('Y-m-d');

			$request_model->save();

			$errors = $request_model->getErrors();

			if (count($errors) > 0) {

				$request_model->addError(100, "Added Error");


				$error_message = '<ul>';
				foreach ($errors as $field => $messages) {

					foreach ($messages as $message) {
						$error_message .= '<li>' . $field . ' : ' . $message . '</li>';

					}
				}
				$error_message .= '</ul>';

				throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
			}

			// $filename = Yii::getPathOfAlias('webroot') . '/docs/datacraft_bi_brochure.pdf';
			// Get the file details
			$library_asset_model = LibraryAssets::model()->findByAttributes( array('asset_name' => $request_model->attributes['resource_name']));
				
			if ($library_asset_model === null) {
				throw new CHttpException(404,'The library asset'.$request_model->attributes['resource_name'].' was not found.<br>');
			}

			$filename = Yii::getPathOfAlias('webroot') . '/' . $library_asset_model->resource_path;

			if (file_exists($filename)) {

				header('Content-Transfer-Encoding: binary');
				header('Content-length: '. filesize($filename));
				// header('Content-Type: '.$model->file_type);
				header('Content-Type: application/pdf');
				header('Content-Disposition: inline; filename='.$request_model->resource_name);
				// ?? header('Content-Disposition: inline; filename='.$library_asset_model->filename);

				@readfile($filename);

			}
			else {
				$error_message = 'The requested file was not found.';
				throw new CHttpException(404,'The requested file was not found.<br>' .  $error_message );
			}



			// echo $contents;

			exit;


		}

	}
	
	function  getProjectDoc() {
		
		// collect user input data
		if(isset($_POST['ReqDoc']))
		{
		
			// /////////////////////////////////////////////////////////////////
			// Get the user input from the submitted form.
			// /////////////////////////////////////////////////////////////////
			$form_input 				= Yii::app()->request->getPost('ReqDoc');
		
			// $requested_doc 				= $form_input['doc'];
			$to_email 					= $form_input['email'];
			$to_email_address 			= $form_input['email'];
			$to_name					= $form_input['name'];
			$area						= $form_input['area'];
			$telephone					= $form_input['phone'];
			$msg						= $form_input['message'];
			// $phone						= $form_input['phone'];
		
			$from_email_adddress 		= 'online@datacraft.co.za';
		
			$email_encrypt 				= urlencode($to_email_address);
			$special_string 			= 'datacraft?'.time();
			$hash 						= md5($email_encrypt.$special_string);
		
			// /////////////////////////////////////////////////////////////////
			// Find if the user is already on the mailing list. Add the user if
			// ...this is a new user.
			// /////////////////////////////////////////////////////////////////
			$user_model 		= MaillistUser::model()->findByAttributes(array('email' => $to_email_address));
		
			if ($user_model != null) {
				// Existing user. Don't do anything
				;
		
			}
			else {
				
		
				// /////////////////////////////////////////////////////////////////
				// New user. Add the user to the mailing list.
				// /////////////////////////////////////////////////////////////////
		
				$user_model						= new MaillistUser;
				$user_model->validated			= 'N';
				$user_model->validation_code	= $hash;
				$user_model->fullname			= $to_name;
				$user_model->email				= $to_email_address;
				$user_model->area 				= $area;
				$user_model->active				= 'N';
				$user_model->subscribe_date		= date('Y-m-d');
				$user_model->details_updated	= date('Y-m-d H:i:s');
				$user_model->subscribe_date		= date('Y-m-d H:i:s');
		
		
				$user_model->save();
		
				$errors = $user_model->getErrors();
		
				if (count($errors) > 0) {
					echo "here";
		
					$user_model->addError(100, "Added Error");
		
		
					$error_message = '<ul>';
					foreach ($errors as $field => $messages) {
						//print_r($messages);
		
						foreach ($messages as $message) {
							$error_message .= '<li>' . $field . ' : ' . $message . '</li>';
							// print_r($message);
		
						}
					}
					$error_message .= '</ul>';
		
					throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
				}
		
			}
		
			// /////////////////////////////////////////////////////////////////
			// Save the document request.
			// /////////////////////////////////////////////////////////////////
		
			$request_model 					= new DocumentRequest;
			$request_model->user_id			= $user_model->attributes['user_id'];
			$request_model->fullname 		= $to_name;
			$request_model->email    		= $to_email_address;
			$request_model->request_date 	= date('Y-m-d H:i:s');
			$request_model->request_code 	= $hash;
			$request_model->resource_name 	= 'project_management.pdf';
		
			$request_model->save();
		
			$errors = $request_model->getErrors();
		
			if (count($errors) > 0) {
		
				$request_model->addError(100, "Added Error");
		
		
				$error_message = '<ul>';
				foreach ($errors as $field => $messages) {
					//print_r($messages);
		
					foreach ($messages as $message) {
						$error_message .= '<li>' . $field . ' : ' . $message . '</li>';
						// print_r($message);
		
					}
				}
				$error_message .= '</ul>';
		
				throw new CHttpException(404,'Errors encountered while trying to save the record.<br>' .  $error_message );
			}
		
		
			// /////////////////////////////////////////////////////////////////
			// Send the email with a thank you note and the link to requested
			// ..respurce.
			// /////////////////////////////////////////////////////////////////
		
			$headers = array(
					'MIME-Version: 1.0',
					'Content-type: text/html; charset=iso-8859-1'
			);
		
		
		
			$from_email_adddress  	=  'Datacraft Online <'.$from_email_adddress.'>';
			$to_email_address		=  $to_name.' <'.$to_email.'>';
		
			// Send validation email
			$data 						= array();
			$data['name']				= $to_name;
			$data['document_title']		= 'Introduction to Project Management';
			$data['hash']				= $hash;
		
			$message					=  $this->renderPartial('document_request_email',$data, true);
		
			Yii::app()->email->send($from_email_adddress, $to_email_address, 'Thank you for your enquiry', $message, $headers);
		
			// Send 'CC'
			$message = "Datacraft Web Inquiry<br/>
			Received from $to_name ( $to_email )<br/>
			Comment $msg)<br/>
			Message : $message<br/>";
			Yii::app()->email->send($from_email_adddress, 'pradesh@datacraft.co.za', 'CPY: Thank you for your enquiry', $message, $headers);
		
			$this->render('resource_request_confirmed', $data);
		
			Yii::app()->end();
		
		}
		
		$this->render('library/project_doc_request', array('doc'=>'project'));
		
	}


	/**
	* Displays the subscription management page
	*/
	public function actionRegister()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		// $this->render('login',array('model'=>$model));

		$page = 'register';

		$this->render($page);

	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionArticle()
	{

		$name 	= Yii::app()->request->getQuery('name',null);
		if ($name != null) {
			$article_model = Article::model()->findByAttributes(array('name' => $name));
		}
		$id 	= Yii::app()->request->getQuery('id',null);
		if ($id != null) {
			$article_model = Article::model()->findByPk($id);
		}
		

		
        if($article_model === null)
            throw new CHttpException(404,'The requested page does not exist.');
		
        $article_data = $article_model->attributes;
        $this->render("article", $article_data);

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