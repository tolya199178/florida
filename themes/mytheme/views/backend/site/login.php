<?php
$this->pageTitle = Yii::app()->name . ' - Login';
?>
<style>
<!--
    div.block {
    float:left;
    padding-right: 20px;
    }
-->
</style>

<?php
    /* @var $this UsersController */
    /* @var $model Users */
    /* @var $form CActiveForm */
 ?>
 
    <div class="form">



<?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => true,
        'errorMessageCssClass'      => 'alert alert-error',
        'clientOptions'             => array(
            'validateOnSubmit'          => true,
            'validateOnChange'          => true,
//             // /////////////////////////
//             'afterValidate'=>'js:function(form,data,hasError){
//                         if(!hasError){
//                                 $.ajax({
//                                         "type":"POST",
//                                         "url":"'.CHtml::normalizeUrl(array("test/eleven")).'",
//                                         "data":form.serialize(),
//                                         "success":function(data){$("#test").html(data);},
            
//                                         });
//                                 }
//                         }'
            
//             // /////////////////////////
        ),
        'htmlOptions'               => array('name' => 'loginform', 'focus'=>'input[type="fldUserName"]:first',),
    ));



?>
<?php
    foreach (Yii::app()->user->getFlashes() as $type=>$flash) {
        echo "<div class='{$type}'>{$flash}</div>";
    }
?>
    <?php echo $form->errorSummary($model); ?>
    

<div class="login-bgd">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.html"><?php echo Yii::app()->params['SITE_NAME']; ?></a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Sign In</h6>			                
			                <div class="social">
	                            <a class="face_login" href="#">
	                                <span class="face_icon">
	                                    <img src="images/facebook.png" alt="fb">
	                                </span>
	                                <span class="text">Sign in with Facebook</span>
	                            </a>
	                            <div class="division">
	                                <hr class="left">
	                                <span>or</span>
	                                <hr class="right">
	                            </div>
	                        </div>
			                    <p class="note">Fields with <span class="required">*</span> are required.</p>
	                        
<!-- 			                <input class="form-control" type="text" placeholder="E-mail address"> -->
			                    <?php echo $form->textField($model,'fldUserName', array('class'=>'form-control', 'placeholder'=>"E-mail address",
'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter your email address or user name", "data-original-title"=>"Enter your email address or user name."			                    
)); ?>
			                    <?php echo $form->error($model,'fldUserName'); ?>
<!-- 			                <input class="form-control" type="password" placeholder="Password"> -->
			                    <?php echo $form->passwordField($model,'fldPassword', array('class'=>'form-control', 'placeholder'=>"Password",
'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter your password", "data-original-title"=>"Enter your password."			                    
)); ?>
			                    <?php echo $form->error($model,'fldPassword'); ?>
			                    
			                <div class="action">
<!-- 			                    <a class="btn btn-primary signup" href="index.html">Login</a> -->
                                <?php echo CHtml::submitButton('Login', array('class'=>'btn btn-primary signup')); ?>
			                    
			                </div>                
			            </div>
			        </div>

			        <div class="already">
			            <p>Don't have an account yet?</p>
			            <a href="signup.html">Sign Up</a>
			        </div>
			    </div>
			</div>
		</div>
	</div>
  
    <?php $this->endWidget(); ?>
    
    </div>
    
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--     <script src="https://code.jquery.com/jquery.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<!--     <script src="bootstrap/js/bootstrap.min.js"></script> -->
<!--     <script src="js/custom.js"></script> -->
  </div>
  
