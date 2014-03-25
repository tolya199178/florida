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

	/*   text-align: left; */
	/*   bottom: 3px; */
	/* /*   left: 0px; */
	*/
	/* /*   width: 23.4043%; */
	*/
	/*   padding-top: 10px; */
	/*   padding-right: 10px; */
	/*   padding-bottom: 10px; */
	/*   padding-left: 10px; */
	/*   box-shadow: #b0b0b0; */
	/*   z-index: 20; */
}
</style>

    <div class="container">
        <!--  start anel -->
        <div class="row">
            <br />
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-warning">
    
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo CHtml::link($model->attributes['business_name'], $model->attributes['business_name'], array('title' => $model->attributes['business_name'])); ?>                                
                        </h3>
                    </div>
    
                    <div class="panel-body">

                            <!-- Main business information panel -->
                            <div class="col-lg-8">
                            
                                <!--  Photo -->
                                <div class="col-lg-12">
                                    <div
                                        style="border: 1px solid #066A75; padding: 3px; width: 450px; height: 450px;"
                                        id="left">
                                        <a href="#"><?php echo CHtml::image(Yii::app()->request->baseUrl .'/uploads/images/business/'.$model->attributes['image'], 'Business Image', array("width"=>"450px" ,"height"=>"450px")); ?></a>
                                    </div>
                                </div>
                                
                                <!-- Image Gallery-->
                                <div class="col-lg-12">
                                Other image thumbnails
                                </div>
                                
                                <span class="business_description"><?php echo $model->attributes['business_description']; ?></span>
                                

                                <!-- Rating -->
                                <div class="col-lg-12">
                                Rating
                                </div>
                                
                                <!-- Tags -->
                                <div class="col-lg-12">
                                Tags and Categories
                                </div>
                                
                                
                                <!-- Contact Details -->
                                <div class="col-lg-12">
                                    <h4>Contact Details</h4>
                                    <p>Address:<br/>
                                       <?php echo $model->attributes['business_address1']; ?></p>
                                    <p><?php echo $model->attributes['business_address2']; ?></p>
                                    <br/>
                                    <p><?php echo $model->attributes['business_city_id']; ?></p>
                                    <br/>
                                    <p><?php echo $model->attributes['business_zipcode']; ?></p>
                                    <br/>
                                    <p>Phone : <?php echo $model->attributes['business_phone']; ?></p>
                                    <p>Ext : <?php echo $model->attributes['business_phone_ext']; ?></p>
                                    <p>Email : <?php echo $model->attributes['business_email']; ?></p>
                                    <p>Website : <?php echo $model->attributes['business_website']; ?></p>

                                </div>
                                
                                

    
                            </div>
                            <!-- /.Main business information panel -->
                            
                            <!--  Right hand panel -->
                            <div class="col-lg-4">
                            
                                
                                <div class="col-lg-12">
                                
                                    <div class="box">
                            
                                        < ? php $this->renderPartial('business_map', array('data' => $this->data)); ? >
                            
                                    </div>
                                    <hr>
                            
                                    <div class="advert">
                                        < ? php $this->renderPartial('//layouts/_advertisement', array('pageId' => 2)); ? >
                            
                                    </div>
                                    <hr>
                            
                                    <div class="white-box featured">
                                        < ? php $this->renderPartial('//layouts/_addnewbusiness'); ? >
                                    </div>
                            
                                    <hr>
                                    <div class="white-box">
                                        < ? php $this->renderPartial('//layouts/_new_business', array('data' => $this->data)); ? >
                                    </div>
                                    <hr>
                                    <div class="widget white-box">
                                        < ? php $this->renderPartial('//layouts/_forums', array('data' => $this->data)); ? >
                                    </div>
                                    <hr>
                                    <div class="white-box">
                                        <h5 class="sidebar-title"><b>Coupons</b>
                                            < ? php echo CHtml::link('View all', array('iframbns', 'id' => $this->data['model']->buns_id), array("class" => "pull-right")); ? >
                                        </h5>
                                        <ul class="sidebar-list">
                            
                                            <li>
                                                <div class="meta">
                            
                                                    < ? php
                                                    $img = Yii::app()->mclass->img('img/Web_Coupon_Shot.jpg', 275, 300);
                                                    $img = CHtml::image($img);
                                                    echo CHtml::link($img, array('iframbns', 'id' => $this->data['model']->buns_id));
                                                    ? >
                            
                                                </div>
                                            </li>
                            
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="white-box">
                                       
                                        < ? php
                                        $review = Yii::app()->mclass->getReviews($this->data['model']->buns_id);
                                        $this->renderPartial('//layouts/_reviews', array('review' => $review, 'pageId' => 2));
                                        ? >
                                    </div>
                                    <hr>
                                    <div class="white-box">
                                        < ? php
                                        $events = Yii::app()->mclass->getUpComeingEvents($this->data['model']->buns_id);
                                        $this->renderPartial('//layouts/_events', array('events' => $events, 'pageId' => 2));
                                        ? >
                            
                                    </div>
                                </div>
                                
    
    
                            </div>
                            <!--  /.Right hand panel  -->

                    </div>
                </div>
            </div>
    
        </div>
        <!--  end panel -->
    </div>

