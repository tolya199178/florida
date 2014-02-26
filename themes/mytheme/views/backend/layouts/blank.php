<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap Admin Theme v3</title>
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
  </head>
  <body>

    <?php echo $content; ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--     <script src="https://code.jquery.com/jquery.js"></script>   -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/jquery-1.10.1.min.js"></script>    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/vendor/bootstrap.min.js"></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/js/custom.js"></script>
  </body>
</html>