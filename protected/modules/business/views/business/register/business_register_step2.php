

        	<div class="row">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'lstBusinessCategories',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">

                        <div style="overflow:auto; height: 200px">
                            <?php
                              echo CHtml::dropDownList('Business_lstBusinessCategories', '',
                                                       CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name'),
                                                       array('class'=>"form-control",'multiple'=>'multiple'));
                            ?>
                        </div>
                        <?php echo $form->error($model,'lstBusinessCategories'); ?>
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
                    <?php echo $form->labelEx($model,'business_keywords',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-4">
                        <?php echo $form->textField($model,'business_keywords',array('class'=>"form-control", 'data-role' => "tagsinput")); ?>
                        <?php echo $form->error($model,'business_keywords'); ?>
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