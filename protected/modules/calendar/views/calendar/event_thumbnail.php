						<!-- COUNTRY ITEM -->

							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<div class="thumbnail">

                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <?php echo CHtml::link($event->event_title, Yii::app()->createUrl('calendar/calendar/showevent/', array('id' => $event->event_id  )), array('title' => $event->event_title)); ?>
                                        </div>
                                        <div class="panel-body">
                                            <div class="product">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                                                    <!-- TODO: render Goes wierd if there is a missing image. Check for image first -->
                                                    <a class='product-img-container' href='#'>
                                <?php
                                                    if(@GetImageSize('./'.$event->getThumbnailUrl()))
                                                    {
                                                        echo CHtml::image($event->getThumbnailUrl(), "Image", array('class'=>"product-img"));
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
                                                            <div class="product-title"><?php echo CHtml::Encode($event->event_title); ?></div>
                                                            <div class="product-description"><?php echo CHtml::Encode($event->event_description); ?></div>

                                                            <div class="button-buy">

                                                                <span class="label label-lg label-danger">
                                                                    <a data-toggle="modal"
                                                                       href="<?php echo Yii::app()->createUrl('calendar/calendar/showevent/', array('id' => $event->event_id  )); ?>"
                                                                       data-target="#modalEventDetails">Details!</a>
                                                                </span>

                                <?php if ($event->is_featured == 'Y') { ?>
                                                                <span class="label label-sucess">Featured</span>
                                <?php }?>

                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <input type="checkbox" name="play" class="play_button" /><label for="play"><span></span></label>


                                                </div>


                                            </div>
                                        </div>
                                    </div>


								</div>

							</div>
							<!-- /COUNTRY ITEM -->

