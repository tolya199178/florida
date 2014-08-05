
        <!--panel-->
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">New Businesses</div>
            <div class="panel-body">
                <!--Business list-->

<?php               foreach ($lstNewBusiness as $itemBusiness) { ?>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <?php
                                $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];

                                if (!empty($itemBusiness['image']))
                                {
                                    if(filter_var($itemBusiness['image'], FILTER_VALIDATE_URL))
                                    {
                                        $imageURL = $itemBusiness['image'];
                                    }
                                    else
                                    {
                                        if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$itemBusiness['image']))
                                        {
                                            $imageURL   = Yii::app()->request->baseUrl .'/uploads/images/business/'.$itemBusiness['image'];
                                        }
                                    }
                                }
                            ?>
                            <a href="#" class="thumbnail" class='featured_category_entry'>
                                 <img src="<?php echo $imageURL; ?>"
                                 alt="<?php echo $itemBusiness['business_name']; ?>" style="width:120px;width:120px;">
                            </a>
                            <a href="<?php echo Yii::app()->createUrl('/business/business/showdetails', array('business_id' => $itemBusiness['business_id'] )); ?>">
                               <?php echo CHtml::encode($itemBusiness['business_name']); ?>
                            </a>

                        </div>
<?php               } ?>

                <!--end of table-->
            </div>
            <div class="panel-footer">
                <a class="btn btn-md btn-info" href="<?php echo Yii::app()->createUrl('/business/business/browse/sortby/newdate'); ?>">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                    Show all new businesses.
                </a>
            </div>

        </div>
        <!--end of panel-->
        <br/>

