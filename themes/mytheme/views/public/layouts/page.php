<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet"
    href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/bootstrap.min.css">
<style>
body {
	padding-top: 50px;
	padding-bottom: 20px;
}
</style>
<!--         <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/bootstrap-theme.css">   -->
<link rel="stylesheet"
    href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/site/main.css">

<script
    src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body id='body'>
    <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

    <!--
    <header>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3">
                <h1>
                    <a href="<?php echo Yii::app()->baseUrl; ?>">
                      <img src="<?php echo Yii::app()->theme->baseUrl."/resources/images/site/logo-v1.png"; ?>" class='logo'>
                </a>
                </h1>
            </div>
            <div class="span9">
                <div class="nav-collapse" id="header_menu">
                    < ? php $this->renderPartial('//layouts/header_navigation', array('cls' => "nav social-root pull-right")); ? >
                </div>
                <! - - nav-collapse  - - >
            </div>
        </div>
    </div>
    </header>
 -->

    <div class="navbar navbar-fixed-top header">
        <div class="container">
            <div class="navbar-header header">
                <button type="button" class="navbar-toggle"
                    data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span> <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php echo Yii::app()->baseUrl; ?>"
                    class="navbar-brand"> <img
                    src="<?php echo Yii::app()->theme->baseUrl."/resources/images/site/logo-v1.png"; ?>">
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('concierge/'); ?>">Concierge</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle"
                        data-toggle="dropdown">Cities<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Add a business</a></li>
                            <li><a href="#">Claim your business</a></li>
                            <li><a href="#">Report</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Search</a></li>
                            <li><a href="#">I want to...</a></li>
                        </ul></li>
                </ul>

                <?php if(Yii::app()->user->isGuest) {$this->widget('UserLogin');} ?>
            </div>
            <!--/.navbar-collapse -->
        </div>
    </div>

    <!-- container -->
    <div class="container-full">


<?php
        // /////////////////////////////////////////////////////////////////////
        // The result of the render() is placed here.
        // /////////////////////////////////////////////////////////////////////
        echo $content;
        // /////////////////////////////////////////////////////////////////////
        // The result of the render() is placed here.
        // /////////////////////////////////////////////////////////////////////

?>

      <footer>
            <p>&copy; Company <?php echo date("Y"); ?></p>
        </footer>
    </div>
    <!-- /container -->


    <!--     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>  -->
    <script>window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

    <script
        src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/bootstrap.min.js"></script>

    <script
        src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/plugins.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/main.js"></script>

    <script type="text/javascript">
// Toolbar login

$(document).ready(function(){


	 $("#frmLogin").submit(function(){

	    $.post('<?php echo Yii::app()->createUrl('webuser/account/login/'); ?>',
	    	   $("#frmLogin").serialize(),
	    	   function(data) {

	    	       window.location.replace(data.redirectUrl);

		       }, 'json');
		       return false;

    });
});

</script>


    <script type="text/javascript">
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src='//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
</body>
</html>