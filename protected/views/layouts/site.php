<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Datacraft Software</title>
<meta name="description" content="">
<meta name="author" content="">
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
<script
    src="<?php echo Yii::app()->request->baseUrl; ?>/resources/libraries/jquery/jquery-1.8.3.js"
></script>
<script
    src="<?php echo Yii::app()->request->baseUrl; ?>/resources/libraries/bootstrap/js/bootstrap.min.js"
></script>
<script
    src="<?php echo Yii::app()->request->baseUrl; ?>/resources/libraries/bootstrap/js/bootstrap-carousel.js"
></script>

<!-- Le styles -->
<link
    href="<?php echo Yii::app()->request->baseUrl; ?>/resources/libraries/bootstrap/css/bootstrap.min.css"
    rel="stylesheet"
>
<!-- 		<link href="css/common.css" rel="stylesheet"> -->
<!-- 		<link href="css/custom2.css" rel="stylesheet"> -->
<link
    href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/styles.css"
    rel="stylesheet"
>
</head>
<body>

    <div class="container" style="background: #fff;box-shadow:0px 0px 20px #898987;">
        <div class="row span12"  style="width: 1124px;">
            <div style="padding-top: 5px;">
                <a href="index.html" id="logo"> <img
                    src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/datacraft_logo.jpg"
                    alt="SmartStart"
                >
                </a>
            </div>
            <nav id="main-nav">
                <ul>
                    <li class="current">
                    	<a href="<?php echo Yii::app()->request->scriptUrl; ?>/"  data-description="All starts here">Home</a>
                    </li>
                     <li>
                        <a href="<?php echo Yii::app()->request->scriptUrl; ?>/site/solutions/type/business/" data-description="All the different stuff" id='mnu_solutions'> Business Solutions</a>
                     </li>
                     <li>
                        <a href="<?php echo Yii::app()->request->scriptUrl; ?>/site/solutions/type/enterprise/" data-description="All the different stuff" id='mnu_solutions'> Enterprise Solutions</a>
                     </li>
                     <li>
                     	<a href="blog.html" data-description="What we think" id='mnu_library' >Library</a>
                     </li>
<!--                     <li> -->
<!--                     	<a href="blog.html" data-description="What we think" >Blog</a> -->
<!--                     </li> -->
<!--                     <li> -->
<!--                     	<a href="portfolio-4-columns.html" data-description="Work we are proud of" >Portfolio</a> -->
<!--                     </li> -->
                    <li>
                    	<a href="<?php echo Yii::app()->request->scriptUrl; ?>/site/contact/" data-description="Enquire here" >Contact</a>
                    </li>
                </ul>
            </nav>

            <!-- end #main-nav -->
            <!--Mega Drop Down Menu HTML. Retain given CSS classes-->

            <div id="solutions_submenu" class="megamenu">
                <div class="column">
                    <h3>Financial Solutions</h3>
                    <ul>
                        <li><a href="http://www.javascriptkit.com">Invoicing</a></li>
                        <li><a href="http://www.dynamicdrive.com/">E-commerce</a></li>
                        <li><a href="http://www.cssdrive.com">Shopping carts</a></li>
                    </ul>
                </div>
                <div class="column">
                    <h3>Web Solutions</h3>
                    <ul>
                        <li><a href="http://www.cnn.com/">Hosting</a></li>
                        <li><a href="http://www.msnbc.com">Design</a></li>
                        <li><a href="http://www.google.com">Content Management</a></li>
                        </li>
                    </ul>
                </div>
                <div class="column">
                    <h3>Business Solutions</h3>
                    <ul>
                        <li><a href="http://www.cnn.com/">Customer Relationship</a></li>
                        <li><a href="http://www.msnbc.com">Surveys and Market Research</a></li>
                        <li><a href="http://www.google.com">Calendar and Schedules</a></li>
                        </li>
                    </ul>
                </div>

                <br style="clear: left" />
                <!--Break after 3rd column. Move this if desired-->
                <div class="column">
                    <h3>Enterprise Solutions</h3>
                    <ul>
                        <li><a href="http://www.javascriptkit.com">Business Intelligence</a></li>
                        <li><a href="http://www.dynamicdrive.com/">Document Management</a></li>
                        <li><a href="http://www.cssdrive.com">ERP</a></li>
                    </ul>
                </div>
                <div class="column">
                    <h3>Consultatancy</h3>
                    <ul>
                        <li><a href="http://www.cnn.com/">IT Project Management</a></li>
                        <li><a href="http://www.msnbc.com">Custom software</a></li>
                        <li><a href="http://www.google.com">Governannce and Strategy</a></li>
                        </li>
                    </ul>
                </div>

            </div>
            <!--Mega Drop Down Menu HTML. Retain given CSS classes-->
            <div id="megamenu2" class="megamenu">
                <div class="column">
                    <h3>Blogs</h3>
                    <ul>
                        <li><a href="http://www.javascriptkit.com">JavaScript
                                Kit</a></li>
                        <li><a href="http://www.dynamicdrive.com/">Dynamic
                                Drive</a></li>
                        <li><a href="http://www.cssdrive.com">CSS Drive</a>
                        </li>
                        <li><a href="http://www.codingforums.com">Coding
                                Forums</a></li>
                        <li><a
                            href="http://www.javascriptkit.com/domref/"
                        >DOM Reference</a></li>
                    </ul>
                </div>
                <div class="column">
                    <h3>Newsletters</h3>
                    <ul>
                        <li><a href="http://www.cnn.com/">CNN</a></li>
                        <li><a href="http://www.msnbc.com">MSNBC</a></li>
                        <li><a href="http://www.google.com">Google</a></li>
                        <li><a href="http://news.bbc.co.uk">BBC News</a>
                        </li>
                    </ul>
                </div>
                <div class="column">
                    <h3>Whitepapers</h3>
                    <ul>
                        <li><a href="http://www.news.com/">News.com</a>
                        </li>
                        <li><a href="http://www.slashdot.com">SlashDot</a>
                        </li>
                        <li><a href="http://www.digg.com">Digg</a></li>
                        <li><a href="http://www.techcrunch.com">Tech
                                Crunch</a>
                        </li>
                    </ul>
                </div>
                <br style="clear: left" />
                <!--Break after 3rd column. Move this if desired-->
<!--                 <div class="column"> -->
<!--                     <h3>Downloads</h3> -->
<!--                     <ul> -->
<!--                         <li><a href="http://www.javascriptkit.com">JavaScript -->
<!--                                 Kit</a></li> -->
<!--                     </ul> -->
<!--                 </div> -->
            </div>
        </div>


        <div id="content' class="box-shadow" style="margin-top:70px;margin-bottom:120px;">
        	<?php echo $content; ?>
        </div>


    </div>
    <!-- /container -->

        <footer>
            <p>&copy; Datacraft 2013</p>
        </footer>



<script type="text/javascript">
$(document).ready(function(){

//	$('#myCarousel').carousel();

	// $(".mailme").defuscate();

	// Enable 'read more type toggle'
	   // toggles
	   $("a.toggle").click(function(){
	      $("#" + this.rel).slideToggle("slow");
//	       return false;
	   });
//	    $("a.toggle").attr({ href: "javascript:;"});

});


</script>



<script
    src="<?php echo Yii::app()->request->baseUrl; ?>/resources/libraries/megamenu/js/megamenu.js"
></script>
<link
    href="<?php echo Yii::app()->request->baseUrl; ?>/resources/libraries/megamenu/css/megamenu.css"
    rel="stylesheet"
>

    <script type="text/javascript">

//jkmegamenu.definemenu("anchorid", "menuid", "mouseover|click")
//jkmegamenu.definemenu("mnu_solutions", "solutions_submenu", "mouseover");
//jkmegamenu.definemenu("mnu_library", "megamenu2", "mouseover");



</script>

</body>
</html>
