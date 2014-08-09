<style>
.shape{
	border-style: solid; border-width: 0 70px 40px 0; float:right; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(360deg);
}
.offer{
	background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.offer:hover {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform:rotate scale(1.1);
    -webkit-transition: all 0.4s ease-in-out;
-moz-transition: all 0.4s ease-in-out;
-o-transition: all 0.4s ease-in-out;
transition: all 0.4s ease-in-out;
    }
.shape {
	border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}
.offer-radius{
	border-radius:7px;
}
.offer-danger {	border-color: #d9534f; }
.offer-danger .shape{
	border-color: transparent #d9534f transparent transparent;
}
.offer-success {	border-color: #5cb85c; }
.offer-success .shape{
	border-color: transparent #5cb85c transparent transparent;
}
.offer-default {	border-color: #999999; }
.offer-default .shape{
	border-color: transparent #999999 transparent transparent;
}
.offer-primary {	border-color: #428bca; }
.offer-primary .shape{
	border-color: transparent #428bca transparent transparent;
}
.offer-info {	border-color: #5bc0de; }
.offer-info .shape{
	border-color: transparent #5bc0de transparent transparent;
}
.offer-warning {	border-color: #f0ad4e; }
.offer-warning .shape{
	border-color: transparent #f0ad4e transparent transparent;
}

.shape-text{
	color:#fff; font-size:12px; font-weight:bold; position:relative; right:-40px; top:2px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(30deg);
}
.offer-content{
	padding:0 20px 10px;
}

</style>



        <h3>Business Adverts :</h3><br/>

<?php   foreach ($lstBusinessAdvertisment as $itemAdvert) { ?>

            <div class="row">
        		<div class="col-xs-4 col-sm-6 col-md-12 col-lg-12">
        			<div class="offer offer-default">
                                <div class="square-box pull-left">
<?php
                                $imageURL = null;

                                if ($itemAdvert->image)
                                {

                                    if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/advertisement/'.$itemAdvert->image))
                                    {
                                        $imageURL = Yii::app()->request->baseUrl .'/uploads/images/advertisement/'.$itemAdvert->image;
                                    }
                                    else
                                    {
                                        $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                    }
                                }
                                else
                                {
                                    $imageURL   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                }
?>
<?php                           if ($imageURL) { ?>
                                    <a href="<?php echo (!empty($itemAdvert->url)?$itemAdvert->url:"#")?>"><?php echo CHtml::image($imageURL, 'Business Image', array("width"=>"100px" ,"height"=>"100px", 'id'=>'business_owner_image')); ?></a>
<?php                           } ?>

    			             </div>
<!--         				<div class="shape"> -->
<!--         					<div class="shape-text"> -->
<!--         						top -->
<!--         					</div> -->
<!--         				</div> -->
        				<div class="offer-content">
        					<h3 class="lead">
        						<?php echo CHtml::encode($itemAdvert->title); ?>
        					</h3>
        					<p>
        						<?php echo CHtml::decode($itemAdvert->content); ?>
        					</p>
        				</div>
        			</div>
        		</div>


            </div>


 <?php  } ?>