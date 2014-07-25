
                        <!-- search listing component -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Events <i class="fa fa-link fa-1x"></i>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                <?php foreach ($mySavedSearch as $itemSearch) { ?>
                                    <li class="list-group-item">
                                        <a href="<?php echo Yii::app()->createURL('/calendar/calendar/details/', array('id' => $itemSearch['search_id']))?>">
                                           <?php echo $itemSearch['search_name']  ; ?>
                                        </a>

                                        <a data-toggle="modal" data-target="#modalEditSearch" class="edit_search btn btn-xs btn-info pull-right" href="<?php echo Yii::app()->createUrl('webuser/profile/editsearch/', array('id' => $itemSearch['search_id'])); ?>">
                                            <i class="glyphicon glyphicon-plus-sign"></i>
                                            Edit
                                        </a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="delete_search btn btn-xs btn-danger pull-right"
                                           href="<?php echo Yii::app()->createUrl('webuser/profile/removesearch/', array('id' => $itemSearch['search_id'])); ?>"
                                           rel="<?php echo $itemSearch['search_id']  ; ?>" >
                                            <i class="glyphicon glyphicon-minus-sign"></i>
                                            Delete
                                        </a>

                                    </li>
                                <?php }?>
                                </ul>

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
