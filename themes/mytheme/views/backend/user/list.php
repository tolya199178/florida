<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerCssFile(Yii::app()->theme->baseUrl . '/resources/libraries/DataTables 1.10.0-beta.2/media/css/jquery.dataTables.css');
  $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/resources/libraries/DataTables 1.10.0-beta.2/media/js/jquery.dataTables.js', CClientScript::POS_END);

?>

<!-- User Details Modal -->
  <!-- Button trigger modal -->
<!--   <a data-toggle="modal" href="#myModal" class="btn btn-primary">Add New User</a> -->
    <a href="<?php echo Yii::app()->createUrl('user/create'); ?>" class="btn btn-primary">Add New User</a>
  
  <br /><br />

  <!-- Modal -->  
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content"></div>  
    </div>  
</div>  
<!-- /.modal -->  



			<table id="user_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>User </th>
						<th>Position</th>
						<th>Office</th>
						<th>Extn.</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>

					</tr>
				</thead>

				<tfoot>
					<tr>
						<th>Name</th>
						<th>Position</th>
						<th>Office</th>
						<th>Extn.</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>

					</tr>
				</tfoot>
			</table>
			
<?php
$data_url   = Yii::app()->createUrl('user/listjson');
$edit_url   = Yii::app()->createUrl('user/edit');
$delete_url = Yii::app()->createUrl('user/delete');


$script = <<<EOD
var table = $('#user_table').DataTable({
        // Setup for Bootstrap support.
        sDom: '<"row"<"span6"l><"span6"f>r>t<"row"<"span6"i><"span6"p>>',
       // sPaginationType: 'bootstrap',
        oLanguage: {
            sLengthMenu: '_MENU_ records per page'
        },
        bFilter: false,

        'bProcessing': true,
        'bServerSide': true,
         'sPaginationType': 'full_numbers',
        'sAjaxSource': '{$data_url}',

        'columnDefs': [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                'render': function ( data, type, row ) {
                    return data +' ('+ row[3]+')';
                },
                'targets': 1
            },
            { 'visible': false,  'targets': [ 0 ] },
            {
                "targets": [-1],
                "data": null,
                // "defaultContent": "<button class='editrow'>Edit</button>" + row[0],
                'render': function ( data, type, row ) {
                    var editurl = "<button class='deleterow btn btn-danger btn-xs'>Delete</button>";
                  //  alert(editurl);
                    return editurl;
                },
            },
            {
                "targets": [-2],
                "data": null,
                // "defaultContent": "<button class='editrow'>Edit</button>" + row[0],
                'render': function ( data, type, row ) {
                    var editurl = "<a class='editrow btn btn-info btn-xs' href='{$edit_url}/user_id/" + row[0] + "'>Edit</a>";
                    // alert(editurl);
                    return editurl;
                },
            } 
        ]
    });

    $('#user_table tbody').on( 'click', 'button', function () {
      
        var className = this.className;
      
        var data = table.row( $(this).parents('tr') ).data();
      
        var result = window.confirm("Do you really want to Delete User " + data[1] + "?");
        if (result == false) {
            e.preventDefault();
            return false;
        }
        else {
        
            $.ajax({
                type: 'POST',
                data: { "user_id": data[0] },
                dataType: 'json',
                url: '{$delete_url}',
                success: function (data) {
                
                    if (data.result == 'success') {
                        // Refresh the table
                        // var oTable = $('#tModuleListing').dataTable();
                        table.draw();   
                    }
                    
                },
                error: function () {
                    alert('Failed to Delete item');
                    // todo: add proper error message 
                }
            });
        }
      

    
    return true;
      
      
      if (className == "editrow") {
        var data = table.row( $(this).parents('tr') ).data();
       // alert( data[0] +"'s salary is: "+ data[ 3 ] );
    
            //  $('#myModal').modal('show');
            url = "{$edit_url}/user_id/" + data[0];
        $('#myModal').removeData();
            $('#myModal').modal({
                remote : url
            });
            //$('#myModal').removeData();
      
      }
      else {
        var data = table.row( $(this).parents('tr') ).data();
      //  alert( "DeleteMe :" + data[0] +"'s salary is: "+ data[ 3 ] );
      }
      
     // debugger;

    } );
EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

<script type="text/javascript">




</script>
	