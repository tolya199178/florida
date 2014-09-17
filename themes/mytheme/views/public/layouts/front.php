<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://demo.bootstraptor.com/assets/ico/favicon.png">

    <title>Florida.com</title>

    <!-- Bootstrap custom core CSS -->
<link rel="stylesheet"
    href="<?php echo Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-3.1.1/dist/css/bootstrap.min.css'; ?>">
    <link href="<?php echo Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-3.1.1/dist/css/carousel.css'; ?>" rel="stylesheet">

<link rel="stylesheet"
    href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/site/main.css">


	<style>
		body{
			padding-top:48px;
		}
		.margin-top-10{
			margin-top:10px;
		}
		.gradient-bg{

			-webkit-box-shadow:  21px -14px 50px rgba(150, 150, 150, 0.05) inset;
			-moz-box-shadow:     21px -14px 50px rgba(150, 150, 150, 0.05) inset;
			box-shadow:          21px -14px 50px rgba(150, 150, 150, 0.05) inset;

			border-left:2px solid #DEDEDE;
			border-top:none;
			border-left:none;
			border-bottom:none;
			border-width:2px;
			-webkit-border-image:
				-webkit-gradient(linear, 0 100%, 0 0, from(rgba(0, 0, 0, .1)), to(rgba(0, 0, 0, 0))) 1 100%;
			-webkit-border-image:
				-webkit-linear-gradient(bottom, rgba(0, 0, 0, .1), rgba(0, 0, 0, 0)) 1 100%;
			-o-border-image:
					 -o-linear-gradient(bottom, rgba(0, 0, 0, .1), rgba(0, 0, 0, 0)) 1 100%;
			-moz-border-image:
				   -moz-linear-gradient(bottom, rgba(0, 0, 0, .1), rgba(0, 0, 0, 0)) 1 100%;
		}


        @media (min-width:992px) {
            .row {
                position: relative;
            }
            #left_panel {
                position: absolute;
                height: 100%;
                overflow:auto;
            }
            #main_panel {
                margin-left: 25%; /* Or float:right; */
                        position: relative;

            }
        }

	</style>

<style>
/* Modal login */
.login_modal_footer{margin-top:5px;}
.login_modal_header .modal-title {text-align: center;font-family:'Philosopher',sans-serif; }
.form-group{position: relative;}
.form-group .login-field-icon {
    font-size: 20px;
    position: absolute;
    right: 15px;
    top: 3px;
    transition: all 0.25s ease 0s;
    padding-top: 2%;
}
.login-modal{
    width:100%;
    padding-bottom:20px;
}
.login_modal_header, .login_modal_footer {background: #709e9e !important;color:#fff;}
.modal-register-btn{margin: 4% 33% 2% 33% ;width:100%;}
.login-modal input{height:40px; box-shadow: none; border:1px solid #ddd;}
.modal-body-left{float:left; width:50%; padding-right:4%; border-right:4px solid #ddd;}
.modal-body-right{float:right; width:47%;}
.login-link{padding:0 20%;}
.modal-social-icons{padding:0 10%;}
.facebook, .twitter, .google, .linkedin {width:100%;height:40px; padding-top:2%; margin-top:2%;}
.modal-icons{margin-left: -10px; margin-right: 20px;}
.google, .google:hover{background-color:#dd4b39;border:2px solid #dd4b39;color:#fff;}
.twitter, .twitter:hover{ background-color: #00aced; border:2px solid #00aced;color: #fff;}
.facebook, .facebook:hover{background-color: #3b5999; border:2px solid #3b5999;color:#fff;}
.linkedin, .linkedin:hover{background-color: #007bb6; border: 2px solid #007bb6; color:#fff;}
#social-icons-conatainer{position: relative;}
#center-line{position: absolute;  right: 265.7px;top: 80px;background:#ddd;  border: 4px solid #DDDDDD;border-radius: 20px;}
.modal-login-btn{width:100%;height:40px; margin-bottom:10px;}
#modal-launcher{margin: 30% 0 0 30%; }


</style>

<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/font-awesome.min.css">

<!--[if lt IE 7]>
	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
	<![endif]-->
    <!-- Fav and touch icons -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->


  <style type="text/css" id="holderjs-style">.holderjs-fluid {font-size:16px;font-weight:bold;text-align:center;font-family:sans-serif;margin:0}</style></head>

  <body>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header login_modal_header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h2 class="modal-title" id="myModalLabel">Login to Your Account</h2>
      		</div>
      		<div class="modal-body login-modal">
      			<br/>
      			<div class="clearfix"></div>
      			<div id='social-icons-conatainer'>
	        		<div class='modal-body-left'>


                <?php
                     $model = new LoginForm();

                     $form=$this->beginWidget('CActiveForm', array(
                    	'id'=>'frmLogin',
                        'action' => Yii::app()->createUrl('webuser/account/login/'),
                    	'enableAjaxValidation'=>false,
                    	'enableClientValidation'=>true,
    // FIXME:                	'clientOptions'=>array(
    // FIXME:              		'validateOnSubmit'=>true,
    // FIXME:             	),
                    	'htmlOptions' => array('class' => 'navbar-form navbar-right'),
                )); ?>



	        			<div class="form-group">
	        			<?php echo $form->textField($model,'fldUserName', array('class'=>'form-control', 'placeholder'=>"E-mail address",
                                        'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter your email address or user name", "data-original-title"=>"Enter your email address or user name."
                                   )); ?>
<!-- 		              		<input type="text" id="username" placeholder="Enter your name" value="" class="form-control login-field"> -->
 		              		<i class="fa fa-user login-field-icon"></i>
		            	</div>

		            	<div class="form-group">
		            	<?php echo $form->passwordField($model,'fldPassword', array('class'=>'form-control', 'placeholder'=>"Password",
                                        'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter your password", "data-original-title"=>"Enter your password."
                                   )); ?>
<!-- 		            	  	<input type="password" id="login-pass" placeholder="Password" value="" class="form-control login-field"> -->
		              		<i class="fa fa-lock login-field-icon"></i>
		            	</div>

<!-- 		            	<a href="#" id="frmLoginButton" class="btn btn-success modal-login-btn">Login</a> -->

		            	 <button type="submit" class="btn btn-success modal-login-btn">Sign in</button>

<!-- 		            	<a href="#" class="login-link text-center">Lost your password?</a> -->
		            	<a  class="login-link text-center" href="<?php echo Yii::app()->createUrl('webuser/account/forgotpassword/'); ?>">Lost your password?
                </a>


            <?php $this->endWidget(); ?>

	        		</div>

	        		<div class='modal-body-right'>
	        			<div class="modal-social-icons">
	        				<a href='<?php echo Yii::app()->createUrl('webuser/account/fblogin/'); ?>' class="btn btn-default facebook"> <i class="fa fa-facebook modal-icons"></i> Sign In with Facebook </a>
<!-- 	        				<a href='#' class="btn btn-default twitter"> <i class="fa fa-twitter modal-icons"></i> Sign In with Twitter </a> -->
<!-- 	        				<a href='#' class="btn btn-default google"> <i class="fa fa-google-plus modal-icons"></i> Sign In with Google </a> -->
<!-- 	        				<a href='#' class="btn btn-default linkedin"> <i class="fa fa-linkedin modal-icons"></i> Sign In with Linkedin </a> -->
	        			</div>
	        		</div>
	        		<div id='center-line'> OR </div>
	        	</div>
        		<div class="clearfix"></div>

        		<div class="form-group modal-register-btn">
        			<button class="btn btn-default"> New User Please Register</button>
        		</div>
      		</div>
      		<div class="clearfix"></div>
      		<div class="modal-footer login_modal_footer">
      		</div>
    	</div>
  	</div>
</div>


  <!-- NAVBAR ================================================== -->
   <nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
        <a href="<?php echo Yii::app()->baseUrl; ?>"
            class="navbar-brand"> <img
            src="<?php echo Yii::app()->theme->baseUrl."/resources/images/site/logo-v1.png"; ?>">
        </a>

	  </div>

	  <!-- Collect the nav links, forms, and other content for toggling -->
	  <div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>

            <li><a href="<?php echo Yii::app()->createUrl('concierge/'); ?>">I WANT TO</a></li>

            <li><a href="<?php echo Yii::app()->createUrl('dialogue/'); ?>">Discussions</a></li>

            <li class="dropdown"><a href="#" class="dropdown-toggle"
                data-toggle="dropdown">Businesses<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo Yii::app()->createUrl('business/business/browse/'); ?>">Show Business</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">Add a business</a></li>
<?php               if (!Yii::app()->user->isGuest) { ?>
<?php                   if (Yii::app()->user->getState('roles') =="Business Owner") { ?>
                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->createUrl('business/business/dashboard/'); ?>">My Businesses</a></li>
<?php                   } ?>
<?php               } ?>


                </ul>
            </li>
            <li><a href="#about">About</a   ></li>
            <li><a href="#contact">Contact</a></li>
		</ul>

<?php           if(Yii::app()->user->isGuest) { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li >
                        <button id='sign_in-modal_lancher' class="btn btn-success btn-lg" data-toggle="modal" data-target="#login-modal">
					       Sign in
					   </button>
                    </li>
                </ul>
<?php           } ?>

<?php           if(!Yii::app()->user->isGuest) { ?>
<?php
    // TODO: Many menu items contain dummy links. This must be populated as supporting
    // TODO: functionality is developed.
?>
                <ul class="nav navbar-nav navbar-right">
                    <li ><a href="#contact">Welcome <?php echo Yii::app()->user->getFirstName()?></a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle"
                        data-toggle="dropdown">Manage Your Account<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->createUrl('dashboard/'); ?>">Dashboard</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->createUrl('webuser/account/manageprofile/'); ?>">Manage Profile</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('webuser/account/changepassword/'); ?>">Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->createUrl('mytravel/'); ?>">My Travels</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('myfriend/myfriend/joinapp/'); ?>">Invite Friends</a></li>

                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->createUrl('webuser/account/logout/'); ?>">Logout</a></li>

                        </ul>

                    </li>
                </ul>

<?php           } ?>

<?php         /*  if(Yii::app()->user->isGuest) {$this->widget('UserLogin');}  */   ?>

	</div><!-- /.navbar-collapse -->
	</div>
</nav>

	<div class="container-full">

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-'  . $key . '">' . $message . "</div>\n";
    }
?>

<?php
        // /////////////////////////////////////////////////////////////////////
        // The result of the render() is placed here.
        // /////////////////////////////////////////////////////////////////////
        echo $content;
        // /////////////////////////////////////////////////////////////////////
        // The result of the render() is placed here.
        // /////////////////////////////////////////////////////////////////////

?>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/jquery-1.10.1.min.js"><\/script>');</script>

    <script type="text/javascript"
        src="<?php echo Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-3.1.1/dist/js/bootstrap.min.js'; ?>" />
    </script>

    <script type="text/javascript">

        $(document).ready( function() {

            $('#frmLogin').on('submit', function(event) {

                event.preventDefault();
                $.post( $(this).attr('action'), $(this).serialize(), function(data) {

                    $('#login-modal').modal('hide');

                    // just try to see the outputs
                    console.log(data)
                    if(data.authenticated===true) {

                    	window.location = data.redirectUrl;
                        // Success code here
                    } else {
                    	window.location = data.redirectUrl;
                        // Error code here
                    }
                }, 'json')
            })
        });

    </script>

</body></html>