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

		<link href="Carousel%20Template%20for%20Bootstrap_files/font-awesome.css" rel="stylesheet">

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

            <li><a href="<?php echo Yii::app()->createUrl('discussions/'); ?>">Discussions</a></li>

            <li><a href="<?php echo Yii::app()->createUrl('calendar/'); ?>">Events</a></li>

            <li class="dropdown"><a href="#" class="dropdown-toggle"
                data-toggle="dropdown">Businesses<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo Yii::app()->createUrl('business/business/browse/'); ?>">Show Business</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">Add a business</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('business/business/claim/'); ?>">Claim your business</a></li>

                </ul>
            </li>
		</ul>
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
                            <li><a href="<?php echo Yii::app()->createUrl('myfriend/'); ?>">My friends</a></li>

                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->createUrl('webuser/account/logout/'); ?>">Logout</a></li>

                        </ul>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    </li>
                </ul>

<?php           } ?>
<?php           if(Yii::app()->user->isGuest) {$this->widget('UserLogin');} ?>

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
<!--     <script src="Carousel%20Template%20for%20Bootstrap_files/jquery.js"></script> -->
<!--     <script src="Carousel%20Template%20for%20Bootstrap_files/bootstrap.js"></script> -->
<!--     <script src="Carousel%20Template%20for%20Bootstrap_files/holder.js"></script> -->

    <script>window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/jquery-1.10.1.min.js"><\/script>');</script>

    <script type="text/javascript"
        src="<?php echo Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-3.1.1/dist/js/bootstrap.min.js'; ?>" />
    </script>

</body></html>