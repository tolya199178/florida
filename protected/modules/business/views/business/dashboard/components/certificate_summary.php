

                        <ul class="list-group">
                            <li class="list-group-item text-muted">Certificate Summary</li>
                            <li class="list-group-item text-right">
                                <span class="pull-left"><strong>All Certificates purchased.</strong></span>
                                <?php echo $myCertificateSummary['countAll']; ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left"><strong>Certificates Issued.</strong></span>
                                <?php echo $myCertificateSummary['countIssued']; ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left"><strong>Certificates Available.</strong></span>
                                <?php echo $myCertificateSummary['countUnIssued']; ?>
                            </li>
                            <li class="list-group-item text-right">
                                <span class="pull-left"><strong>Certificates Redeemed.</strong></span>
                                <?php echo $myCertificateSummary['countRedeemed']; ?>
                            </li>
                            <li class="list-group-item text-center">
                                <a class="btn btn-md btn-warning" href="<?php echo Yii::app()->createUrl('certificates/certificates/'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Manage your certificates
                                </a>
                            </li>
                        </ul>