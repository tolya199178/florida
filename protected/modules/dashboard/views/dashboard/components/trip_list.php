<?php

$myActiveTrips      = $data['myActiveTrips'];

?>
                        <!-- search listing component -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Trips <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($myActiveTrips as $itemTrip) { ?>
                                    <li class="list-group-item">
                                        <a href="<?php echo Yii::app()->createURL('/mytravel/mytravel/manage', array('trip' => $itemTrip['trip_id']))?>">
                                           <?php echo $itemTrip['trip_name']  ; ?>
                                        </a>

                                    </li>
                                <?php }?>
                                </ul>

                                <a class="btn btn-lg btn-default" href="<?php echo Yii::app()->createUrl('mytravel/mytravel/show'); ?>">
                                    <i class="glyphicon glyphicon-plus-sign"></i>
                                    Manage your trips
                                </a>

                            </div>
                        </div>

                        <!-- ./search listing component -->


<!-- Modal -->
<div class="modal fade" id="modalEditSearch" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->


<?php
$script = <<<EOD

    // Clear the modal each time
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    $(document).on('click','.delete_search', function(e){
            var result = window.confirm("Do you really want to Delete the saved search?");
            if (result == false) {
                e.preventDefault();
                return false;
            }
            else {
                 $.ajax({
                 	type: 'POST',
                 	url: $(this).attr("href"),
                 	datatype:"json",
                 	data: {search_id: $(this).attr("rel")} ,
                 	success: function(data, status) {
                  	   location.reload();
                 	}
             	});
                 return false;
            }

    })


EOD;

Yii::app()->clientScript->registerScript('search_actions', $script, CClientScript::POS_READY);

?>
