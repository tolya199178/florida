<!DOCTYPE html>
<html>
  <head>
    <title><?php echo Yii::app()->params['SITE_NAME']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/bootstrap.min.css">
        <!-- styles -->
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/resources/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">


    </style>
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.html"><?php echo Yii::app()->params['SITE_NAME']; ?> Admin</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              <div class="row">
	                <div class="col-lg-12">
	                  <div class="input-group form">
	                       <input type="text" class="form-control" placeholder="Search...">
	                       <span class="input-group-btn">
	                         <button class="btn btn-primary" type="button">Search</button>
	                       </span>
	                  </div>
	                </div>
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="profile.html">Profile</a></li>
	                          <li><a href="login.html">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">

                  <!-- start menu 1 -->
                  <ul class="nav nav-list">
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>

                      <li class="nav-divider"></li>

                      <!-- System Menu -->
                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>System</a>
                          <ul class="nav nav-list tree active-trial">
                              <li><a href="<?php echo Yii::app()->createUrl('/activity/index'); ?>">Activities</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/mailtemplate/index'); ?>">Email Templates</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/category/index'); ?>">Categories</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/mobilecarrier/index'); ?>">Mobile Carriers</a></li>

                        </ul>
                      </li>


                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>Users</a>
                          <ul class="nav nav-list tree">
                              <li><a href="<?php echo Yii::app()->createUrl('/user/index'); ?>">Admin Users</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/user/index'); ?>">Site Users</a></li>
                          </ul>
                      </li>

                      <!-- Business Menu -->
                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>Business</a>
                          <ul class="nav nav-list tree active-trial">
                              <li><a href="<?php echo Yii::app()->createUrl('/businessadmin/index'); ?>">Business Listing</a></li>
                          </ul>
                      </li>

                      <!-- Cities Menu -->
                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>Cities</a>
                          <ul class="nav nav-list tree active-trial">
                              <li><a href="<?php echo Yii::app()->createUrl('/city/index'); ?>">Cities Listing</a></li>
                          </ul>
                      </li>

                      <!-- Events Menu -->
                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>Events</a>
                          <ul class="nav nav-list tree active-trial">
                              <li><a href="<?php echo Yii::app()->createUrl('/event/index'); ?>">Events Listing</a></li>
                        </ul>
                      </li>

                      <!-- Restaurant Certificates Menu -->
                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>Restaurant Certificate</a>
                          <ul class="nav nav-list tree active-trial">
                              <li><a href="<?php echo Yii::app()->createUrl('/restaurantcertificate/import'); ?>">Import Certificates</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/restaurantcertificate/list'); ?>">Certificates Listing</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/restaurantcertificate/price'); ?>">Set Purchase Price</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/restaurantcertificate/summary'); ?>">Summary</a></li>
                          </ul>
                      </li>

                      <!-- Coupon Menu -->
                      <li class="nav-divider"></li>
                      <li><a class="tree-toggler nav-header"><i class="glyphicon glyphicon-home"></i>Business Tools</a>
                          <ul class="nav nav-list tree active-trial">
                             <li><a href="<?php echo Yii::app()->createUrl('/advertisement/index'); ?>">Adverts</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/couponadmin/list'); ?>">Coupons</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/banneradmin/list'); ?>">Banners</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/questionnaire/index'); ?>">Questionnaires</a></li>
                              <li><a href="<?php echo Yii::app()->createUrl('/packageadmin/list'); ?>">Packages</a></li>
                          </ul>
                      </li>


                      <li class="nav-divider"></li>
                  </ul>

                 <!--  END menu test -->


             </div>
		  </div>

		  <div class="col-md-10">

              <?php echo $content; ?>

              <p>&nbsp;</p>

		  </div>

		</div>

    </div>



    <footer>
         <div class="container">

            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>

         </div>
      </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script>window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
          <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/custom.js"></script>

        <script type="text/javascript">
        $(document).ready(function() {

            $('a.tree-toggler').click(function () {
            	  $(this).parent().children('ul.tree').toggle(300);
            	});

            $("[data-toggle='tooltip']").tooltip();

        });
        </script>

  </body>
</html>