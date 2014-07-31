<?php

    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);

?>

<style>
#main {
	background-color: white;
	/* top: 66px; */
	margin-top: -36px;
	position: relative;
}
</style>


<style>
ul.nav-wizard {
	background-color: #f9f9f9;
	border: 1px solid #d4d4d4;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	*zoom: 1;
	position: relative;
	overflow: hidden;
}

ul.nav-wizard:before {
	display: block;
	position: absolute;
	left: 0px;
	right: 0px;
	top: 46px;
	height: 47px;
	border-top: 1px solid #d4d4d4;
	border-bottom: 1px solid #d4d4d4;
	z-index: 11;
	content: " ";
}

ul.nav-wizard:after {
	display: block;
	position: absolute;
	left: 0px;
	right: 0px;
	top: 138px;
	height: 47px;
	border-top: 1px solid #d4d4d4;
	border-bottom: 1px solid #d4d4d4;
	z-index: 11;
	content: " ";
}

ul.nav-wizard li {
	position: relative;
	float: left;
	height: 46px;
	display: inline-block;
	text-align: middle;
	padding: 0 20px 0 30px;
	margin: 0;
	font-size: 16px;
	line-height: 46px;
}

ul.nav-wizard li a {
	color: #468847;
	padding: 0;
}

ul.nav-wizard li a:hover {
	background-color: transparent;
}

ul.nav-wizard li:before {
	position: absolute;
	display: block;
	border: 24px solid transparent;
	border-left: 16px solid #d4d4d4;
	border-right: 0;
	top: -1px;
	z-index: 10;
	content: '';
	right: -16px;
}

ul.nav-wizard li:after {
	position: absolute;
	display: block;
	border: 24px solid transparent;
	border-left: 16px solid #f9f9f9;
	border-right: 0;
	top: -1px;
	z-index: 10;
	content: '';
	right: -15px;
}

ul.nav-wizard li.active {
	color: #3a87ad;
	background: #d9edf7;
}

ul.nav-wizard li.active:after {
	border-left: 16px solid #d9edf7;
}

ul.nav-wizard li.active a,ul.nav-wizard li.active a:active,ul.nav-wizard li.active a:visited,ul.nav-wizard li.active a:focus
	{
	color: #3a87ad;
	background: #d9edf7;
}

ul.nav-wizard .active ~ li {
	color: #999999;
	background: #ededed;
}

ul.nav-wizard .active ~ li:after {
	border-left: 16px solid #ededed;
}

ul.nav-wizard .active ~ li a,ul.nav-wizard .active ~ li a:active,ul.nav-wizard .active
	~ li a:visited,ul.nav-wizard .active ~ li a:focus {
	color: #999999;
	background: #ededed;
}

ul.nav-wizard.nav-wizard-backnav li:hover {
	color: #468847;
	background: #f6fbfd;
}

ul.nav-wizard.nav-wizard-backnav li:hover:after {
	border-left: 16px solid #f6fbfd;
}

ul.nav-wizard.nav-wizard-backnav li:hover a,ul.nav-wizard.nav-wizard-backnav li:hover a:active,ul.nav-wizard.nav-wizard-backnav li:hover a:visited,ul.nav-wizard.nav-wizard-backnav li:hover a:focus
	{
	color: #468847;
	background: #f6fbfd;
}

ul.nav-wizard.nav-wizard-backnav .active ~ li {
	color: #999999;
	background: #ededed;
}

ul.nav-wizard.nav-wizard-backnav .active ~ li:after {
	border-left: 16px solid #ededed;
}

ul.nav-wizard.nav-wizard-backnav .active ~ li a,ul.nav-wizard.nav-wizard-backnav .active
	~ li a:active,ul.nav-wizard.nav-wizard-backnav .active ~ li a:visited,ul.nav-wizard.nav-wizard-backnav .active
	~ li a:focus {
	color: #999999;
	background: #ededed;
}
</style>





<div class="container">







    <!--  start panel -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

        <br />


<?php   $form=$this->beginWidget('CActiveForm', array(
                    	'id'=>'business-details-form',
                        'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
                    	'enableAjaxValidation'  => false,
                     ));
?>
        <div class="panel panel-default">

            <!-- Panel Header  -->
            <div class="panel-heading">
                <h3 class="panel-title">Register a New Business Account</h3>
            </div>
            <!-- ./ Panel Header  -->



            <!-- Panel Body -->
            <div class="panel-body">

<!--  Tab Container -->
<div class="container" id="myWizard">

   <!--  Tab headers -->
   <div class="navbar">
      <div class="navbar-inner">
            <ul class="nav nav-pills">
               <li class="active"><a href="#step1" data-toggle="tab">Contact Details</a></li>
               <li><a href="#step2" data-toggle="tab">Business Description</a></li>
            </ul>
      </div>
   </div>
   <!--  ./Tab headers -->

   <!--  Tab Contents -->
   <div class="tab-content">

      <!-- Step 1 contents -->
      <div class="tab-pane active" id="step1">

            <?php $this->renderPartial("register/business_register_step1",
                                        array('form'=>$form, 'model'=>$model));
            ?>

            <!-- Panel Footer -->
            <div class="panel-footer">
                <a class="btn btn-default next" href="#">Continue</a>
            </div>
      </div>
      <!-- ./Step 1 contents -->

      <!-- Step 2 contents -->
      <div class="tab-pane" id="step2">

            <?php $this->renderPartial("register/business_register_step2",
                                       array('form'=>$form, 'model'=>$model));
            ?>

            <!-- Panel Footer -->
            <div class="panel-footer">
		          <?php echo CHtml::submitButton('Save the Business Record', array('class'=>"btn btn-success btn-lg")); ?>
            </div>
      </div>
      <!-- ./ Step 2 contents -->

   </div>
   <!--  Tab Contents -->

</div>
<!--  ./ Tab Container -->



            </div>
            <!-- ./ Panel Body -->

            <!-- Panel Footer -->
<!--             <div class="panel-footer"> -->
<!--                 Panel footer -->
<!--             </div> -->
            <!-- ./ Panel Header  -->
        </div>
<?php   $this->endWidget(); ?>






        </div>

    </div>
    <!--  end panel -->
</div>


<?php
$baseUrl = $this->createAbsoluteUrl('/');

// $cityAutoCompleteURL = Yii::app()->createUrl('/banner/banner/autocompletepagelist');
$categoryListUrl = $baseUrl.'/business/business/autocompletecatlist/';


$script = <<<EOD

    // next wizard button
    $('.next').click(function(){

    	  var nextId = $(this).parents('.tab-pane').next().attr("id");
    	  $('[href=#'+nextId+']').tab('show');

	})

    // wizard button 1
	$('.first').click(function(){

	   $('#myWizard a:first').tab('show')

	})

    $("#Business_business_city_id").select2({
        placeholder: "Select the city",
        allowClear: true
    });


    $("#Business_lstBusinessCategories").select2({
        placeholder: "Select one or more categories",
    });

EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

