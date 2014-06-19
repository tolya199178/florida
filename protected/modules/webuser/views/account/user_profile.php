<?php
//print_r($model);
//exit;
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


<style type="text/css">

.my_friend_selected  {
    display: none;
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
                <h3 class="panel-title">Manage my Profile</h3>
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
                              <li class="active"><a href="#mydetails" data-toggle="tab">My Details</a></li>
                              <li><a href="#myprofile" data-toggle="tab">My Public Profile</a></li>
                              <li><a href="#myfriends" data-toggle="tab">My Friends</a></li>
                              <li><a href="#mymessages" data-toggle="tab">My Messages</a></li>
                              <li><a href="#myimages" data-toggle="tab">My Images</a></li>
                              <li><a href="#myactivities" data-toggle="tab">My Activities</a></li>
                            </ul>
                      </div>
                   </div>
                   <!--  ./Tab headers -->

                   <!--  Tab Contents -->
                   <div class="tab-content">

                      <!-- Step 1 contents -->
                      <div class="tab-pane active" id="mydetails">

                            <?php $this->renderPartial("user_profile_details", array('form'=>$form, 'model'=>$model)); ?>

                            <!-- Panel Footer -->
                            <div class="panel-footer">
                                <a class="btn btn-default next" href="#">Continue</a>
                            </div>
                      </div>
                      <!-- ./Step 1 contents -->

                      <!-- Step 2 contents -->
                      <div class="tab-pane" id="myprofile">

                            <?php $this->renderPartial("user_profile_settings",array('form'=>$form, 'model'=>$model)); ?>

                            <!-- Panel Footer -->
                            <div class="panel-footer">
                                <a class="btn btn-default next" href="#">Continue</a>
                            </div>
                      </div>
                      <!-- ./ Step 2 contents -->

                      <!-- Step 3 contents -->
                      <div class="tab-pane" id="myfriends">

                            <?php $this->renderPartial("user_profile_my_friends",array('form'=>$form, 'model'=>$model, 'myLocalFriends'=>$myLocalFriends, 'myOnlineFriends'=>$myOnlineFriends)); ?>

                            <!-- Panel Footer -->
                            <div class="panel-footer">
                                  <a class="btn btn-default next" href="#">Continue</a>
                            </div>
                      </div>
                      <!-- ./ Step 3 contents -->

                      <!-- Step 4 contents -->
                      <div class="tab-pane" id="mymessages">

                            <?php $this->renderPartial("//message/list",array('form'=>$form, 'model'=>$model, 'myMessages'=>$myMessages)); ?>

                            <!-- Panel Footer -->
                            <div class="panel-footer">
                                  <a class="btn btn-default next" href="#">Continue</a>
                            </div>
                      </div>
                      <!-- ./ Step 4 contents -->

                      <!-- Step 5 contents -->
                      <div class="tab-pane" id="myimages">

                            <?php $this->renderPartial('//user_photos/list', array('myPhotos' => $myPhotos)); ?>
                            <?php $this->renderPartial('//user_photos/new_image'); ?>

                            <!-- Panel Footer -->
                            <div class="panel-footer">
                                  <a class="btn btn-default next" href="#">Continue</a>
                            </div>
                      </div>
                      <!-- ./ Step 5 contents -->

                      <!-- Step 6 contents -->
                      <div class="tab-pane" id="myactivities">

                            <?php $this->renderPartial('//user_activities/listall', array('myActivities' => $myActivities)); ?>

                            <!-- Panel Footer -->
                            <div class="panel-footer">
                		          <?php echo CHtml::submitButton('Save the Business Record', array('class'=>"btn btn-success btn-lg")); ?>
                            </div>
                      </div>
                      <!-- ./ Step 6 contents -->



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
$script = <<<EOD

    $('.next').click(function(){

    	  var nextId = $(this).parents('.tab-pane').next().attr("id");
    	  $('[href=#'+nextId+']').tab('show');

    	})

    	$('.first').click(function(){

    	  $('#myWizard a:first').tab('show')

    	})


EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

