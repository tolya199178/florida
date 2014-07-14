<?php

$listMyBusiness         = $data['listMyBusiness'];
$currentBusiness        = $data['currentBusiness'];
$myCertificateSummary   = $data['myCertificateSummary'];

?>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Businesses <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <p>In focus : <?php echo ($currentBusiness != null)?$currentBusiness->business_name:'&lt;Not selected&gt;'; ?></p>

                                <p>
                                    <a class="btn btn-md btn-warning" href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">
                                        <i class="glyphicon glyphicon-write-sign"></i>
                                        Change Business Details
                                    </a>
                                </p>

                                <p>
                                    <a class="btn btn-md btn-danger" href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">
                                        <i class="glyphicon glyphicon-minus-sign"></i>
                                         Remove Listing
                                    </a>
                                </p>

                                <ul class="list-group">
                                <?php foreach ($listMyBusiness as $itemBusiness) { ?>
                                    <li class="list-group-item"><a href="<?php echo Yii::app()->createURL('/business/business/dashboard', array('business' => $itemBusiness->business_id))?>"><?php echo $itemBusiness->business_name; ?></a></li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('business/business/add/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Add a business
                                </a>
                            </div>
                        </div>


<!--                         <div class="container"> -->
<!--                             <ul class="nav nav-tabs" id="myTab"> -->
<!--                                 <li class="active"><a href="#details" data-toggle="tab">Details</a></li> -->
<!--                                 <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
<!--                                 <li><a href="#preferences" data-toggle="tab">Preferences</a></li> -->
<!--                             </ul> -->
<!--                             <div class="tab-content"> -->
<!--                                 <div class="tab-pane active" id="details">TODO: Details...</div> -->
<!--                                 <div class="tab-pane" id="settings">TODO: Settings...</div> -->
<!--                                 <div class="tab-pane" id="preferences">TODO: Preferences...</div> -->
<!--                             </div> -->
<!--                         </div> -->

                        <p>&nbsp;</p>


                        <?php $this->renderPartial('dashboard/components/certificate_summary', array('myCertificateSummary'=>$myCertificateSummary)); ?>
