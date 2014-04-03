<?php
// print_r($data->attributes);
?>
<div class="col-lg-3">

    <div class="panel panel-warning">

        <div class="panel-heading">
            <h3 class="panel-title">
                <?php echo CHtml::link($data->business_name, Yii::app()->createUrl('/business/profile/'), array('title' => $data->business_name)); ?>
            </h3>
        </div>

        <div class="panel-body">
            <span class="business_description"><?php echo $data->business_description; ?></span>

                <div class="col-lg-12">


                    <div class="product">
                    <!-- TODO: render Goes wierd if there is a missing image. Check for image first -->
                    <a class='product-img-container' href='#'>
<?php
              if(@GetImageSize('./'.$data->getThumbnailUrl()))
                    {
                        echo CHtml::image($data->getThumbnailUrl(), "Image", array('class'=>"product-img"));
                    }
                    else
                    {
                        echo CHtml::image(Yii::app()->theme->baseUrl .'/resources/images/site/no-image.jpg', "No image available", array('class'=>"product-img"));
                    }
?>
                    </a>
                      <div class="product-actions">
                        <div class="product-info">
                          <div class="sale-tile">
                            <div class="sale">NEW</div>
                          </div>
                          <div class="info-block">
                            <div class="product-title"><?php echo $data->business_name; ?></div>
                            <div class="product-description"><?php echo $data->business_description; ?></div>
                            <div class="product-sale">$17</div>
                            <div class="product-prize">$36</div>
                            <div class="button-buy">
<?php if (!Yii::app()->user->isGuest) { ?>
                                <span class="label label-danger">Add to profile</span>
<?php }?>
<?php if ($data->claim_status == 'Unclaimed') { ?>
                                <span class="label label-danger">Not claimed</span>
<?php }?>
<?php if ($data->is_featured == 'Y') { ?>
                                <span class="label label-sucess">Featured</span>
<?php }?>

                            </div>
<!--                             <div class="add">Add</div> -->
                          </div>
                        </div>
                      </div>
                      <input type="checkbox" name="play" id="play" /><label for="play"><span></span></label>
                      <div class="jvideo">
<?php               if(@GetImageSize('./'.$data->getThumbnailUrl()))
                    {
                        echo CHtml::image($data->getThumbnailUrl(), "Image", array('class'=>"product-img"));
                    }
                    else
                    {
                        echo CHtml::image(Yii::app()->theme->baseUrl .'/resources/images/site/no-image.jpg', "No image available", array('class'=>"product-img"));
                    }
?>
                      </div>
                       <div class="more"></div>
                    <!--     <div class="nav"> -->
                    <!--       <ul> -->
                    <!--         <li>Share</li> -->
                    <!--         <li>Info</li> -->
                    <!--         <li>Seller</li> -->
                    <!--       </ul> -->
                    <!--     </div> -->
                    </div>

                </div>

<?php if ((!Yii::app()->user->isGuest) && ($data->business_allow_review == 'Y')) { ?>
                <span><input type="number" name="your_awesome_parameter" id="some_id" class="rating" /></span>
<?php } ?>
         </div>

    </div>


</div>


