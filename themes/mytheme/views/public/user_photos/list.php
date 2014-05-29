          <div class="row">

                <div class=col-lg-12>
                    <h1>My Photos</h1>
                </div>

                <div class=col-lg-12>
<?php   foreach ($myPhotos as $itemPhoto) { ?>

                    <div class='col-lg-4'>

                        <div class='myphoto thumbnail'>
                            <div
                                style="border: 1px solid #066A75; padding: 3px; width: 150px; height: 150px;"
                                id="left">
                                <a href="#"><?php echo CHtml::image(Yii::app()->request->baseUrl .'/uploads/images/user/'.$itemPhoto->attributes['path'], 'User Image', array("width"=>"150px" ,"height"=>"150px")); ?></a>
                            </div>
                        </div>


                    </div>


<?php }?>

                </div>

            </div>