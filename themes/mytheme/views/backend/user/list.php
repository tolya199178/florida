<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerCssFile(Yii::app()->theme->baseUrl . '/resources/libraries/DataTables 1.10.0-beta.2/media/css/jquery.dataTables.css');
  $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/resources/libraries/DataTables 1.10.0-beta.2/media/js/jquery.dataTables.js', CClientScript::POS_END);

?>

			<table id="user_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>User </th>
						<th>Position</th>
						<th>Office</th>
						<th>Extn.</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						
<!-- 						<th>Start date</th> -->
<!-- 						<th>Salary</th> -->
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
						
<!-- 						<th>Start date</th> -->
<!-- 						<th>Salary</th> -->
					</tr>
				</tfoot>
			</table>
			
<?php
$data_url = Yii::app()->createUrl('user/listjson');

$script = <<<EOD
var table = $('#user_table').DataTable({
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
                "defaultContent": "<button class='deleterow'>Delete</button>"
            },
            {
                "targets": [-2],
                "data": null,
                "defaultContent": "<button class='editrow'>Edit!</button>"
            } 
        ]
    });

    $('#user_table tbody').on( 'click', 'button', function () {
      
      // var className = $(this).attr('className');
      var className = this.className;
      if (className == "editrow") {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s salary is: "+ data[ 3 ] );
      }
      else {
        var data = table.row( $(this).parents('tr') ).data();
        alert( "DeleteMe :" + data[0] +"'s salary is: "+ data[ 3 ] );
      }
      
      debugger;

    } );
EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

/*
Yii::app()->clientScript->registerScript('register_script_name', "
      
$('#user_table').dataTable({
        'bProcessing': true,
        'bServerSide': true,
        'sPaginationType': 'full_numbers',
        'sAjaxSource': '{$data_url}',

        ],
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
            { 'visible': false,  'targets': [ 0 ] }
        ]
    });
      
", CClientScript::POS_READY);


*/
?>

	