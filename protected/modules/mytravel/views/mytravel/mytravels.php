<?php

$listMyTravels     = $data['myTravels'];

?>

<style>

.travel_list {
    height:300px;overflow-y:auto;overflow-x:off;
}

.travel_list li {
    background-clip: padding-box;
    border-radius: 4px;
    list-style-type: none;
    overflow: hidden;
    padding: 1em 0 1em 1em;
}

.travel_list ul li {
    list-style: disc inside none;
    padding-left: 20px;
}

.travel_list h2, .travel_list p {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    margin: 0;
    padding-bottom: 0;
}
.travel_list p, .travel_list h2 {
    width: 360px;
}

h2 {
    font-size: 32px;
    padding-bottom: 10px;
}

/* */


.travel_list li:hover
{
  background-color: #eff1f9;
  cursor: pointer;
  box-shadow: #bbbbbb;
}
</style>


                        <div class="panel panel-default">


                            <div class="panel-heading">
                                My Trips <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">


                            <ul class="list-group travel_list">


                                <?php foreach ($listMyTravels as $myTravel) { ?>
                                	<li>

                                	   <div class='col-lg-12'>
                                    		<h2><a href="#">
                                		        <?php echo CHtml::encode($myTravel->trip_name); ?>
                                    		    </a>
                                    		</h2>

                                    		<p><span><?php echo CHtml::encode($myTravel->description); ?></span></p>

                                    		<p><span><strong>Status:</strong>&nbsp;</span><span><?php echo CHtml::encode($myTravel->trip_status); ?></span></p>
                                    		<p><span><strong>Location:</strong>&nbsp;</span><span><?php echo CHtml::encode($myTravel->trip_name); ?></span></p>
                                    		<p>
                                                <a class="btn btn-sm btn-success" href="<?php echo Yii::app()->createUrl('mytravel/mytravel/manage/', array('trip'=>$myTravel->trip_id)); ?>">
                                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                                    Manage
                                                </a>

                                                <a class="btn btn-sm btn-danger" href="<?php echo Yii::app()->createUrl('myfriend/myfriend/rejectrequest/', array('trip'=>$myTravel->trip_id)); ?>">
                                                    <i class="glyphicon glyphicon-minus-sign"></i>
                                                    Delete Trip
                                                </a>

                                    		</p>
                                    		<br/>
                                	   </div>


                                	   <hr/>
                                	</li>

                                <?php } ?>
                                </ul>

                            </div>

                        </div>