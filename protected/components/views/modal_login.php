

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
                    </div>
                    <div class="form-group">
                        <?php echo $form->passwordField($model,'fldPassword', array('class'=>'form-control', 'placeholder'=>"Password",
                                        'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter your password", "data-original-title"=>"Enter your password."
                                   )); ?>
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>

                &nbsp;&nbsp;&nbsp;
                <a class="face_login" href="<?php echo Yii::app()->createUrl('webuser/account/fblogin/'); ?>">
                    <span class="face_icon">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/resources/images/facebook.png" alt="fb">
                    </span>
                </a>
                &nbsp;&nbsp;&nbsp;
                <a
                    href="<?php echo Yii::app()->createUrl('webuser/account/register/'); ?>">Not a member?
                </a>
                &nbsp;&nbsp;&nbsp;

                <a
                    href="<?php echo Yii::app()->createUrl('webuser/account/forgotpassword/'); ?>">Lost password?
                </a>
                &nbsp;&nbsp;&nbsp;

                <?php $this->endWidget(); ?>



