<?php
/* Inherited local variables */
/* @var $this BusinessController */
/* @var $model Business */
/* @var $form CActiveForm */
?>
<?php
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/js/vendor/typeahead/typeahead.bundle.js', CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.js', CClientScript::POS_END);
// Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.css');

    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2-bootstrap.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);


?>
<?php

$listActivity = Activity::model()->getListjson();
$data_url = Yii::app()->createUrl('concierge/prefecthlistall');

$script = <<<EOD


//     $('#Business_business_activities').tagsinput({
//         typeahead: {
//             source:  {$listActivity}
//         }
//     });


//     $('input').tagsinput();

    // Adding custom typeahead support using http://twitter.github.io/typeahead.js
    $('input').tagsinput('input').typeahead({
        prefetch: '{$data_url}'
    }).bind('typeahead:selected', $.proxy(function (obj, datum) {
        this.tagsinput('add', datum.value);
        this.tagsinput('input').typeahead('setQuery', '');
    }, $('input')));


EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

<style>
.row > .form-group
/* .form-group */
{
    padding-top:10px;
    padding-bottom:10px;
}

<style>
<!--
.typeahead,.tt-query,.tt-hint {
	width: 250px;
	/*   height: 30px; */
	padding: 8px 12px;
	/*   font-size: 24px; */
	/*   line-height: 30px; */
	border: 2px solid #ccc;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	outline: none;
}

.typeahead {
	background-color: #fff;
}

.typeahead:focus {
	border: 2px solid #0097cf;
}

.tt-query {
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
	color: #999
}

.tt-dropdown-menu {
	width: 250px;
	margin-top: 12px;
	padding: 8px 0;
	background-color: #fff;
	border: 1px solid #ccc;
	border: 1px solid rgba(0, 0, 0, 0.2);
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	-webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
	-moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
	box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
}

.tt-suggestion {
	padding: 3px 20px;
	/*   font-size: 18px; */
	line-height: 24px;
}

.tt-suggestion.tt-cursor {
	color: #fff;
	background-color: #0097cf;
}

.tt-suggestion p {
	margin: 0;
}


</style>

    <h3>Update Business : <?php echo CHtml::encode($model->business_name); ?></h3>
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Manage Business</a>
        </div>
        <div>
            <div class="navbar-form navbar-left" role="search">
                <div class="form-group">

                    <ul class="nav nav-tabs" id="myTab">
                      <li><a href="#profile" data-toggle="tab" class="btn btn-primary">Profile</a></li>
                      <li><a href="#contact" data-toggle="tab" class="btn btn-primary">Contact</a></li>
                      <li><a href="#categorisation" data-toggle="tab" class="btn btn-primary">Categorisation</a></li>
                      <li><a href="#settings" data-toggle="tab" class="btn btn-primary">Settings</a></li>
                    </ul>
                </div>
            </div>


        </div>
    </nav>



        <!-- todo: jquery order loading issue where setting enableAjaxValidation=true -->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-details-form',
    'htmlOptions'           => array('role' => 'form', 'enctype' => 'multipart/form-data'/* 'class' => "form-horizontal" */),
	'enableAjaxValidation'  => false,
)); ?>

    <?php if($model->hasErrors()) {  ?>
        <div class="alert alert-danger">
        	<?php echo $form->errorSummary($model); ?>
        </div>
    <?php } ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>



	<?php echo $form->hiddenField($model,'business_id'); ?>

    <div class="tab-content">

        <!-- Profile Tab -->
        <div class="tab-pane active" id="profile">
        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_name',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_name',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business name", "data-original-title"=>"Enter business name.")); ?>
                        <?php echo $form->error($model,'business_name'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_description',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-10">
                        <?php $this->widget('application.extensions.editor.CKkceditor',array(
            				"model"=>$model,                # Data-Model
            				"attribute"=>'business_description',         	# Attribute in the Data-Model
            				"height"=>'220px',
            				"width"=>'75%',
            			    ) );
                        ?>
                        <?php echo $form->error($model,'business_description'); ?>
                    </div>
                </div>
        	</div>



        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'activation_code',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'activation_code',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter activation code", "data-original-title"=>"Enter activation code.")); ?>
                        <?php echo $form->error($model,'activation_code'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'fldUploadImage',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo CHtml::activeFileField($model,'fldUploadImage',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Uplaod image", "data-original-title"=>"Upload image.")); ?>
                        <?php echo $form->error($model,'fldUploadImage'); ?>
                    </div>
                </div>
        	</div>

<?php if (!empty($model->image)) { ?>
        	<div class="row">
                <div class="form-group">
                    <span class="col-sm-2 control-label">Current Image</span>
                    <div class="col-sm-4">
                        <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                            <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/business/thumbnails/'.$model->image,
                                                    "Image",
                                                    array('width'=>150, 'height'=>150))); ?>
                        </div>
                    </div>
                </div>
        	</div>
<?php } ?>


        </div>
        <!-- /.Profile Tab -->


        <!-- Contact Tab -->
        <div class="tab-pane" id="contact">

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_email',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_email',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter email", "data-original-title"=>"Enter email.")); ?>
                        <?php echo $form->error($model,'business_email'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_website',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_website',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business website", "data-original-title"=>"Enter business website.")); ?>
                        <?php echo $form->error($model,'business_website'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_phone',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_phone',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business phone", "data-original-title"=>"Enter business phone.")); ?>
                        <?php echo $form->error($model,'business_phone'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_phone_ext',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_phone_ext',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business phone extension", "data-original-title"=>"Enter business phone extension.")); ?>
                        <?php echo $form->error($model,'business_phone_ext'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_address1',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textArea($model,'business_address1',array('class'=>"form-control", 'rows' => 4, 'cols' => 300,
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business address ", "data-original-title"=>"Enter address.")); ?>
                        <?php echo $form->error($model,'business_address1'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_address2',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textArea($model,'business_address2',array('class'=>"form-control",  'rows' => 4, 'cols' => 300,
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business address", "data-original-title"=>"Enter business address.")); ?>
                        <?php echo $form->error($model,'business_address2'); ?>
                    </div>
                </div>
        	</div>

        	<!--  Add a city selection dropdown -->
        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_city_id',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,'business_city_id', CHtml::listData(City::model()->findAll(), 'city_id', 'city_name'), array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select City", "data-original-title"=>"Select city.")); ?>
                        <?php echo $form->error($model,'business_city_id'); ?>
                        <!--  todo: styling for dropdown -->
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_zipcode',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_zipcode',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business zipcode", "data-original-title"=>"Enter business zipcode.")); ?>
                        <?php echo $form->error($model,'business_zipcode'); ?>
                    </div>
                </div>
        	</div>
        </div>
        <!--  /.Contact Tab -->

        <!-- Categorisation Tab -->
        <div class="tab-pane" id="categorisation">

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'lstBusinessCategories',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">

                        <div style="overflow:auto; height: 200px">
                            <?php
                            /* BUG: The CheckBoxList forces a '-- Choose a Category --' as a first Roo level iten */

                                  $parents = Category::model()->findAll('parent_id is null');
                                  $data = Category::model()->makeDropDown($parents);

                                  echo $form->CheckBoxList($model,'lstBusinessCategories', $data);
                            ?>
                        </div>
                        <?php echo $form->error($model,'lstBusinessCategories'); ?>
                    </div>
                </div>
        	</div>


        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_keywords',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_keywords',array('class'=>"form-control", 'data-role' => "tagsinput",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business keywords", "data-original-title"=>"Enter business keywords.")); ?>
                        <?php echo $form->error($model,'business_keywords'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_activities',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model,'business_activities',array('class'=>"form-control", 'data-role' => "tagsinput",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter business activities", "data-original-title"=>"Enter business activities.")); ?>
                        <?php echo $form->error($model,'business_activities'); ?>
                    </div>
                </div>
        	</div>


        </div>
        <!-- /.Categoriation Tab -->

        <!-- Settings Tab -->
        <div class="tab-pane" id="settings">

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'add_request_processed_by',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'add_request_processed_by',array('class'=>"form-control",'readonly' => 'readonly',
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Request processed by", "data-original-title"=>"Request processed by.")); ?>
                        <?php echo $form->error($model,'add_request_processed_by'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'add_request_rejection_reason',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'add_request_rejection_reason',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Add request rejection reason", "data-original-title"=>"Add request rejection reason.")); ?>
                        <?php echo $form->error($model,'add_request_rejection_reason'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'claimed_by',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'claimed_by',array('class'=>"form-control", 'readonly' => 'readonly',
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Claimed by", "data-original-title"=>"Claimed by.")); ?>
                        <?php echo $form->error($model,'claimed_by'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'claim_rejection_reason',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'claim_rejection_reason',array('class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Enter claim rejection reason", "data-original-title"=>"Enter claim rejection reason.")); ?>
                        <?php echo $form->error($model,'claim_rejection_reason'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_allow_review',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->checkBox($model,'business_allow_review', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Check business allow review", "data-original-title"=>"Check business allow review.")); ?>
                        <?php echo $form->error($model,'business_allow_review'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'is_for_review',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->checkBox($model,'is_for_review', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control")); ?>
                        <?php echo $form->error($model,'is_for_review'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'business_allow_rating',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->checkBox($model,'business_allow_rating', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Check business allow rating", "data-original-title"=>"Enter business allow rating.")); ?>
                        <?php echo $form->error($model,'business_allow_rating'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'claim_status',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,
                                                       'claim_status',
                                                       $model->listClaimStatus(),
                                                       array('prompt'=>'Select Status', 'class'=>"form-control",
                                                           'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select claim status", "data-original-title"=>"Select claim status.")
                        );?>
                        <?php echo $form->error($model,'claim_status'); ?>
                    </div>
                </div>
        	</div>



        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'add_request_processing_status',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,
                                                       'add_request_processing_status',
                                                       $model->listAddRequestProcessingStatus(),
                                                       array('prompt'=>'Select Status', 'class'=>"form-control",
                                                           'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select request processing status", "data-original-title"=>"Select request processing status.")
                        );?>
                        <?php echo $form->error($model,'add_request_processing_status'); ?>
                    </div>
                </div>
        	</div>

       	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'is_active',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->checkBox($model,'is_active', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Check is active", "data-original-title"=>"Check is active.")); ?>
                        <?php echo $form->error($model,'is_active'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'is_featured',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->checkBox($model,'is_featured', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Check is featured", "data-original-title"=>"Check is featured.")); ?>
                        <?php echo $form->error($model,'is_featured'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'is_closed',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->checkBox($model,'is_featured', array('value' => 'Y', 'uncheckValue'=>'N','class'=>"form-control",
                            'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Check is closed", "data-original-title"=>"Check is closed.")); ?>
                        <?php echo $form->error($model,'is_closed'); ?>
                    </div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'activation_status',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,
                                                       'activation_status',
                                                       $model->listActivationStatus(),
                                                       array('prompt'=>'Select Status', 'class'=>"form-control",
                                                           'data-toggle' => "tooltip", "data-placement" => "bottom", "title"=>"Select activation status", "data-original-title"=>"Select activation status.")
                        );?>
                    <?php echo $form->error($model,'activation_status'); ?>
                    </div>
                </div>
        	</div>



        </div>
        <!-- /.Settings Tab -->
    </div>

    <p>&nbsp;</p>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save the Business Record', array('class'=>"btn btn-success btn-lg")); ?>
	</div>

<?php $this->endWidget(); ?>



<?php

$jsonActivityTree = CJSON::encode($actvityTree);

$script = <<<EOD

    var data = {$jsonActivityTree};

    $("#Business_business_activities").select2({
        multiple: true,
        width: "300px",
        data: {results: data, text: "text"},
        formatSelection: function(item) {
            return item.text
        },
        formatResult: function(item) {
            return item.text
        }
    });



    $("#Business_business_city_id").select2();


EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>