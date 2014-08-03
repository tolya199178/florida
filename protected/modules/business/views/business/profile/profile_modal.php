<style>
#map_canvas {
	width: 500px;
	height: 500px;
}
</style>



<style>
      ul {
          padding:0 0 0 0;
          margin:0 0 0 0;
      }
      ul li {
          list-style:none;
          margin-bottom:25px;
      }
      ul li img {
          cursor: pointer;
      }

  </style>



   <input type="hidden" id="business_id" name="business_id"  value="<?php echo (int) $model->attributes['business_id']; ?>" /><br/>


   <div class="modal-dialog biz-details-modal1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Business Details</h4>

            </div>

            <!-- Modal body -->
            <div class="modal-body">



                <div class="panel panel-warning">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo CHtml::link(CHtml::encode($model->attributes['business_name']), $model->attributes['business_id'], array('title' => CHtml::encode($model->attributes['business_name']))); ?>
                        </h3>
                    </div>

                    <div class="panel-body">

                    <div class="row">

                        <div class="col-md-6">
                                <!--  Photo -->
                                <div class="col-lg-12">
                                    <div
                                        style="border: 1px solid #066A75; padding: 3px; width: 450px; height: 450px;"
                                        id="left">
                                        <a href="#">
                                        <?php
                                            if(filter_var($model->attributes['image'], FILTER_VALIDATE_URL))
                                            {
                                                $imageURL = $model->attributes['image'];
                                            }
                                            else
                                            {
                                                $imageURL = Yii::app()->request->baseUrl .'/uploads/images/business/'.$model->attributes['image'];
                                            }
                                        ?>
                                        <?php echo CHtml::image($imageURL, 'Business Image', array("width"=>"450px" ,"height"=>"450px", 'id'=>'business_main_image_view')); ?>
                                        </a>
                                    </div>
                                </div>
                                <!-- Photo -->
                        </div>
                        <div class="col-md-6">

                                <div class="map_box">

                                    <?php $this->renderPartial('profile/business_map', array('model'=>$model)); ?>

                                </div>
                                <hr>

                                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('/business/business/showdetails', array('business_id' => $model->business_id  )); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Show more details
                                </a>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-8">



                                <!-- Image Gallery-->
                                <div class="col-lg-12">
                                    <h4>Photos :</h4><br/>

                                        <ul class="row">
<?php                                   foreach ($photos as $photo) { ?>
                                            <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <?php
                                                    if(filter_var($photo->path, FILTER_VALIDATE_URL))
                                                    {
                                                        $imageURL = $photo->path;
                                                    }
                                                    else
                                                    {
                                                        $imageURL = Yii::app()->request->baseUrl .'/uploads/images/business/'.$photo->path;
                                                    }
                                                ?>
                                                <img class="img-responsive" src="<?php echo $imageURL; ?>" style="width:120px;width:120px;">
                                            </li>
<?php                                   } ?>
                                        </ul>
                                </div>
                                <!-- Image gallery -->

                                <!-- Business description -->
                                <div class="col-lg-12">

                                    <span class="business_description"><?php echo CHtml::encode($model->attributes['business_description']); ?></span>

                                </div>
                                <!-- ./Business description -->

                                <!-- Tags -->
                                <div class="col-lg-12">
                                  <h4>Tags and Categories :</h4><br/>
<?php

                                  // Business categories
                                  foreach ($model->businessCategories as $businessCategory)
                                  {
                                      $modelCategory = Category::model()->findByPk($businessCategory->category_id);
                                      if ($modelCategory != null)
                                      {
?>
                                        <span class="label label-sucess"><?php echo CHtml::encode($modelCategory->category_name); ?></span>
<?php
                                      }

                                  }
?>
                                </div>

                                <!-- Contact Details -->
                                <div class="col-lg-12">
                                    <h4>Contact Details</h4>
                                    <p>Address:<br/>
                                       <?php echo CHtml::encode($model->attributes['business_address1']); ?></p>
                                    <p><?php echo CHtml::encode($model->attributes['business_address2']); ?></p>
                                    <br/>
                                    <p><?php echo CHtml::encode($model->attributes['business_city_id']); ?></p>
                                    <br/>
                                    <p><?php echo CHtml::encode($model->attributes['business_zipcode']); ?></p>
                                    <br/>
                                    <p>Phone : <?php echo CHtml::encode($model->attributes['business_phone']); ?></p>
                                    <p>Ext : <?php echo CHtml::encode($model->attributes['business_phone_ext']); ?></p>
                                    <p>Email : <?php echo CHtml::encode($model->attributes['business_email']); ?></p>
                                    <p>Website : <?php echo CHtml::encode($model->attributes['business_website']); ?></p>
                                    <p>&nbsp;</p>
                                    <p>Business Hours : Open : <?php echo CHtml::encode($model->attributes['opening_time']); ?></p>
                                    <p>Business Hours : Close : <?php echo CHtml::encode($model->attributes['closing_time']); ?></p>

                                </div>

                                <!-- Coupons -->
                                <hr>
                                <div class="white-box">
                                    <h5 class="sidebar-title"><b>Coupons</b>
                                    </h5>
                                    <ul class="sidebar-list">

                                        <?php $this->renderPartial("profile/business_coupons", array('model'=>$model)); ?>

                                    </ul>
                                </div>



                        </div>

                        <div class="col-md-4">

                            <div class="col-lg-12">


                                <!-- Reviews -->
                                <hr>
                                <div class="white-box">
                                    <!-- Rating -->
                                    <div class="col-lg-12">
                                        <h4>Reviews :</h4><br/>
<?php if ((!Yii::app()->user->isGuest) && ($model->business_allow_review == 'Y')) { ?>
                                        <button class="pop-review-form" rel="review_popover" refid="<?php echo (int) $model->business_id; ?>"  >Your Review</button>

                                        <!-- Review form popup -->
                                        <div class="row" id="review-box" style="display:none;">
                                            <div class="col-md-12">
                                                <form accept-charset="UTF-8" action="" method="post" id='review_form'>
                                                    <input type='hidden' id="review_business_id" name="review_business_id" value="<?php echo (int) $model->business_id; ?>">
                                                    <textarea class="form-control animated" cols="50" id="review_text" name="review_text" placeholder="Enter your review here..." rows="5"></textarea>

                                                    <span><input type="number" name="review_rating" id="review_rating"  class="review_rating" value='' /></span>

                                                    <div class="text-right">
                                                        <button class="close-review btn btn-error btn-lg" type="reset">Cancel</button>
                                                        <button class="btn btn-success btn-lg" type="submit">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.Review form popup -->
<?php } ?>

                                        <h4>Other Reviews :</h4><br/>
<?php

                                        // Business reviews
                                        foreach ($model->businessReviews as $businessReview)
                                        {
                                            $this->renderPartial("profile/business_reviews",array('model' => $businessReview));
                                        }
?>

                                    </div>
                                </div>
                                <!-- /.Reviews -->

                                <!-- Tell a friend -->
                                <hr>
                                <div class="white-box">
                                    <?php $this->renderPartial("profile/tell_a_friend", array('model' => $model)); ?>
                                </div>
                                <!-- ./Tell a friend -->


<?php if (!Yii::app()->user->isGuest) { ?>
                                <!-- Report Business Closed -->
                                <hr>
                                <div class="white-box">
                                    <button class="pop-report-closed-biz" refid="<?php echo (int) $model->business_id; ?>"  >Report Business Closed</button>
                                    <!-- Review form popup -->
                                    <div class="row" id="report-closed-biz" style="display:none;">
                                        <div class="col-md-12">
                                            <form accept-charset="UTF-8" action="" method="post" id='report-closed-biz_form'>
                                                <input type='hidden' id="business_id" name="business_id" value="<?php echo (int) $model->business_id; ?>">
                                                <textarea class="form-control animated" cols="50" id="reference" name="reference" placeholder="Enter your details here..." rows="5"></textarea>

                                                <div class="text-right">
                                                    <button class="close-report-closed btn btn-error btn-lg" type="reset">Cancel</button>
                                                    <button class="btn btn-success btn-lg" type="submit">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.Review form popup -->
                                </div>
                                <!-- ./Report Business Closed -->
<?php } ?>


                                <hr>
                                <div class="white-box">
                                    <?php $this->renderPartial('profile/business_events', array('model' => $model->events)); ?>
                                </div>

                            </div>

                        </div>



                    </div>

                    </div>

                </div>
                <!--  End of Panel -->


            </div>
            <!-- Modal body -->

            <div class="modal-footer">
            <button type="button" class="btn btn-default wiz-close-nav " data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary wiz-finish-nav">OK</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
<!-- </form> -->



