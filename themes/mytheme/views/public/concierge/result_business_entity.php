<?php
// print_r($data->attributes);
?>
<div class="col-lg-4">

    <div class="panel panel-warning">

        <div class="panel-heading">
            <h3 class="panel-title">
                <?php echo CHtml::link($data->business_name, Yii::app()->createUrl('/business/profile/'), array('title' => $data->business_name)); ?>
            </h3>
        </div>

        <div class="panel-body">
            <span class="business_description"><?php echo CHtml::Encode($data->business_description); ?></span>

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
                            <div class="product-title"><?php echo CHtml::Encode($data->business_name); ?></div>
                            <div class="product-description"><?php echo CHtml::Encode($data->business_description); ?></div>
                            <!--  TODO: Prices are hardcoded (POC only). Will be resolved when restaurant.com data comes online -->
<!--  TODO: These are currently placeholders. Must be populated once restauramt.com data is available -->
                            <span class="product-sale">$17</span>
                            <span class="product-prize">$36</span>
<!--  TODO: END: Prices are hardcoded (POC only). Will be resolved when restaurant.com data comes online -->


                            <div class="button-buy">

                                <span class="label label-lg label-danger"><?php echo CHtml::link('Details', Yii::app()->createUrl('businessuser/profile/show/', array('id' => $data->business_id  )), array('class' => 'details_button_link', 'rel' => $data->business_id)); ?></span>

<?php if ((!Yii::app()->user->isGuest) && (!SubscribedBusiness::isSubcribed(Yii::app()->user->id, $data->business_id)))  { ?>
                                <span class="label label-danger"><?php echo CHtml::link('Add to profile', Yii::app()->createUrl('/webuser/profile/addbusiness', array('business_id' => $data->business_id  )), array('class' => 'result_button_link', 'rel' => $data->business_id)); ?></span>
<?php }?>
<?php if (!Yii::app()->user->isGuest) { ?>
                                <a class="label label-lg label-info" data-toggle="modal" href="/concierge/invitefriends/business/<?php echo $data->business_id; ?>" data-target="#inviteMyFriends">Invite My Friends</a>
<?php }?>
<?php if ($data->is_featured == 'Y') { ?>
                                <span class="label label-sucess">Featured</span>
<?php }?>
<?php if ((!Yii::app()->user->isGuest) && ($data->business_allow_review == 'Y')) { ?>
<!--             <span><input type="number" name="your_awesome_parameter" id="some_id"  class="rating" rel="<?php echo $data->business_id; ?>" /></span>  -->

                <button class="pop-review-form" rel="review_popover" refid="<?php echo $data->business_id; ?>"  >Review</button>

<?php } ?>

                            </div>
<!--                             <div class="add">Add</div> -->
                          </div>
                        </div>
                      </div>
                      <input type="checkbox" name="play" class="play_button" /><label for="play"><span></span></label>

                    </div>

                </div>

<?php

      // Business categories
      foreach ($data->businessCategories as $business_category)
      {
          $modelCategory = Category::model()->findByPk($business_category->category_id);
          if ($modelCategory != null)
          {
?>
               <span class="label label-sucess"><?php echo CHtml::Encode($modelCategory->category_name); ?></span>
<?php
        }

      }
?>

<?php
        // Keywords. stored as a comma seperated list
        $lstKeywords = explode(",", CHTML::encode($data->business_keywords));
        foreach ($lstKeywords as $keyword)
        {
?>
              <span class="label label-danger"><?php echo $keyword; ?></span>
<?php
        }
?>

         </div>

    </div>


</div>

