<?php
/* @var $this PackageController */
/* @var $model Package */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'package-create-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
    'htmlOptions' => array('role' => 'form', 'enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'package_name',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'package_name',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'package_name'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'package_expire',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
                        <?php echo $form->dropDownList($model,
                                                       'package_expire',
                                                       $model->listExpiryPeriods(),
                                                       array('prompt'=>'Select Expiry Period', 'class'=>"form-control")
                        );?>
	                    <?php echo $form->error($model,'package_expire'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'package_price',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-4">
	                    <?php echo $form->textField($model,'package_price',array('class'=>"form-control")); ?>
	                    <?php echo $form->error($model,'package_price'); ?>
	                </div>
	            </div>
	    	</div>
	    	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'fldUploadImage',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo CHtml::activeFileField($model,'fldUploadImage',
                                array(
                                    'class'=>"form-control",
                                    'data-toggle' => "tooltip",
                                    "data-placement" => "bottom",
                                    "title"=>"Upload image",
                                    "data-original-title"=>"Upload image."
                                ));
                        ?>
                        <?php echo $form->error($model,'fldUploadImage'); ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($model->package_image)) { ?>
                <div class="row">
                    <div class="form-group">
                        <span class="col-sm-2 control-label">Image</span>
                        <div class="col-sm-4">
                            <div style="border: 1px solid #066A75; padding: 3px; width:  150px; height: 150px   ; " id="left">
                                <?php
                                    echo CHtml::link(
                                            CHtml::image(Yii::app()->request->baseUrl.'/uploads/images/package/thumbnails/'.$model->package_image,
                                            "Image",
                                            array('width'=>150, 'height'=>150))
                                        );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

	    	<div class="row">
	            <div class="form-group">
	                <?php echo $form->labelEx($model,'package_description',array('class'=>"col-sm-2 control-label")); ?>
	                <div class="col-sm-10">
                        <?php $this->widget('application.extensions.editor.CKkceditor',array(
                            "model"=>$model,                # Data-Model
                            "attribute"=>'package_description',         	# Attribute in the Data-Model
                            "height"=>'300px',
                            "width"=>'90%',
                            ) );
                        ?>
	                    <?php echo $form->error($model,'package_description'); ?>
	                </div>
	            </div>
	    	</div>

            <div class="row">
	            <div class="form-group">
                    <label class="col-sm-2 control-label">Items</label>
	                <div class="col-sm-10">
                        <div class="container">
                        <?php
                            $packageItems = array();
                            foreach($model->packageItems as $item) {
                                $packageItems['item_type' . $item['item_type_id']] = $item['quantity'];
                            }
                            $k = 0;
                            foreach($itemTypes as $type) {
                        ?>
                            <div class="row">
                                <label class="col-sm-2 control-label"><?php echo CHtml::encode($type['name'])?></label>
                                <div class="col-sm-2">
                                    <?php
                                        echo CHtml::hiddenField('item_type_id['.$k.']', $type['package_item_type_id']);
                                        $value = isset($packageItems['item_type' . $type['package_item_type_id']]) ?
                                                $packageItems['item_type' . $type['package_item_type_id']] : 0;
                                        if($type['has_quantity'] > 0) {
                                            echo CHtml::numberField('item_value['.$k.']' , $value, array('min' => 0));
                                        } else {
                                            echo CHtml::checkBox('item_value['.$k.']', $value);
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php
                                $k++;
                            }
                        ?>
                        </div>
	                </div>
	            </div>
	    	</div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Submit'); ?>
            </div>

<?php $this->endWidget(); ?>

</div><!-- form -->