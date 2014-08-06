          <div class="col-sm-3">
            <div class="col-item">
                <div class="thumbnail">
                    <div class="caption">
                        <h4><?php echo CHtml::encode($data->business_name); ?></h4>
                        <p>short thumbnail description</p>
                        <p>
                             <a data-toggle="modal" class="label label-danger" title="Zoom" data-target="#modalBusinessDetails"
                                href="<?php echo Yii::app()->createUrl('business/business/show/', array('id' => $data->business_id  )); ?>">
                             Details
                             </a>
                             &nbsp;&nbsp;
                            <?php if ((!Yii::app()->user->isGuest) && (!SubscribedBusiness::isSubcribed(Yii::app()->user->id, $data->business_id)))  { ?>
                                <?php echo CHtml::link('Add to profile', Yii::app()->createUrl('/webuser/profile/addbusiness', array('business_id' => $data->business_id  )), array('class' => 'result_button_link label label-default', 'rel' => $data->business_id)); ?>
                            <?php }?>
                        </p>
                    </div>
                    <img src="http://lorempixel.com/400/300/business/4/" alt="...">
                </div>
                <div class="info">
                    <div class="row">
                        <div class="col-md-12  clear-left">
                            <h4 class='business_name'><?php echo CHtml::encode($data->business_name); ?></h4>
                            <h5 class="business_address">
                                <?php echo CHtml::encode($data->business_address1.','.$data->business_address2.','.$data->businessCity['city_name']); ?>
                            </h5>
                        </div>
                        <div class="price col-md-6">
<?php
//                                Business keywords
                                  $labelStyle = array('label-primary', 'label-success', 'label-default', 'label-info', 'label-warning', 'label-danger');

                                  $lstkeywords = explode(",", $data->business_keywords);

                                  foreach ($lstkeywords as $keywordIndex => $itemKeyword)
                                  {
                                       $labelType = $labelStyle[($keywordIndex % count($labelStyle))];
?>
                                        <span class="label <?php echo $labelType; ?>"><?php echo CHtml::encode($itemKeyword); ?></span>
<?php
                                  }
?>
                        </div>
                        <div class="rating hidden-sm col-md-6">
<?php                       for ($i=0; $i< $data->star_rating; $i++) { ?>
                                <i class="price-text-color fa fa-star"></i>
<?php                       } ?>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                     <div class="separator clear-left">
                         <p class="btn-add">
                             <i class="fa fa-envelope-o"></i><br/>
                                <?php if (!Yii::app()->user->isGuest) { ?>
                                    <a class="label label-lg label-info launch-modal" href="#modalInviteMyFriends" data-href="/concierge/invitefriends/business/<?php echo $data->business_id; ?>">Invite My Friends</a>
                                <?php }?>
                             </p>
                         <p class="btn-details">
                             <i class="fa fa-list"></i><br/>
                             <a data-toggle="modal" class="label label-lg label-warning"
                                href="<?php echo Yii::app()->createUrl('business/business/show/', array('id' => $data->business_id  )); ?>"
                                data-target="#modalBusinessDetails">More details
                             </a>

                             </p>
                     </div>
                    <div class="clearfix">
                    </div>
                </div>
            </div>
        </div>