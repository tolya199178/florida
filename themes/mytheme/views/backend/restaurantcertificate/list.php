<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/resources/libraries/DataTables-1.10.0/media/css/jquery.dataTables.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/resources/libraries/DataTables-1.10.0/media/js/jquery.dataTables.js', CClientScript::POS_END);

?>

<style type="text/css">
    .dataTables_filter {
        display: none;
    }

    #popover-content {
        margin-right: -800px;
        max-width: 600px;
        width: 800px;
    }
</style>



<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Manage Restaurant Certificates</a>
    </div>
    <div>
        <div class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <a
                    href="<?php echo Yii::app()->createUrl('restaurantcertificate/create'); ?>"
                    class="btn btn-primary">Add New Restaurant Certificate</a>
            </div>
        </div>
        <div class="navbar-form navbar-right" role="search">
            <div class="form-group">
                <input type="text" class="form-control" id="searchbox"
                       placeholder="Search">
            </div>

            <a data-placement="bottom" data-toggle="popover" data-title=""
               data-container="body" type="button" data-html="true" href="#"
               id="login" class="btn btn-primary">Advanced Search</a>
            <div id="popover-content" class="hide">


                <form name="searchform" id="searchform" action="" method="post">
                    <div class="form">
                        <input type="hidden" name="searchmode" id="searchmode" value="" /><br/>
                        <div class="row">
                            <div class="form-group">
                                <?php echo CHtml::label('Certificate Number','certificate_number',array('class'=>"col-sm-2 control-label")); ?>
                                <div class="col-sm-10">
                                    <?php echo CHtml::textField('certificate_number','',array('class'=>"form-control")); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row buttons">
                            <?php echo CHtml::submitButton('Submit'); ?>
                        </div>
                    </div>

                </form>


                <p id="renderingEngineFilter"></p>
                <p id="browserFilter"></p>
                <p id="platformsFilter"></p>
                <p id="engineVersionFilter"></p>
                <p id="cssGradeFilter"></p>

            </div>

        </div>


    </div>
</nav>

<table id="restaurantcertificate_table" class="table table-striped table-bordered"
       cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Restaurantcertificate ID</th>
        <th>Certificate Number</th>
        <th>Date Purchased</th>
        <th>Purchase Price</th>
        <th>Date Issued</th>
        <th>Issued to Business</th>
        <th>Date Claimed</th>
        <th>Issued to Client</th>
        <th>Value of Certificate</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>

    </tr>
    </thead>
</table>

<?php
$data_url = Yii::app()->createUrl('restaurantcertificate/listjson');
$edit_url = Yii::app()->createUrl('restaurantcertificate/edit');
$delete_url = Yii::app()->createUrl('restaurantcertificate/delete');

$script = <<<EOD
    var table = $('#restaurantcertificate_table').DataTable({
            // Setup for Bootstrap support.
            sDom: '<"row"<"span6"l><"span6"f>r>t<"row"<"span6"i><"span6"p>>',
            oLanguage: {
                sLengthMenu: '_MENU_ records per page'
            },
            // bFilter: false,

            'bProcessing': true,
            'bServerSide': true,
             'sPaginationType': 'full_numbers',
            "ajax": {
                "url": '{$data_url}',
                "data": {
                    "certificate_number": $("#certificate_number").val(),
                },
                "type": "POST"
            },

            'columnDefs': [
                // These columns not visible
                { 'visible': false,  'targets': [ 0 ] },

                // In row delete button
                {
                    "targets": [-1],
                    "data": null,
                    'render': function ( data, type, row ) {
                        var editurl = "<button class='deleterow btn btn-danger btn-xs'>Delete</button>";
                      //  alert(editurl);
                        return editurl;
                    },
                },

                // In row edit button
                {
                    "targets": [-2],
                    "data": null,
                    'render': function ( data, type, row ) {
                        var editurl = "<a class='editrow btn btn-info btn-xs' href='{$edit_url}/certificate_id/" + row[0] + "'>Edit</a>";
                        // alert(editurl);
                        return editurl;
                    },
                },

            ]
        });

        $('#restaurantcertificate_table tbody').on( 'click', 'button', function () {

            var className = this.className;

            var data = table.row( $(this).parents('tr') ).data();

            var result = window.confirm("Do you really want to Delete the restaurant certificate record for " + data[1] + "?");
            if (result == false) {
                e.preventDefault();
                return false;
            }
            else {

                $.ajax({
                    type: 'POST',
                    data: { "restaurant_certificate_id": data[0] },
                    dataType: 'json',
                    url: '{$delete_url}',
                    success: function (data) {

                        if (data.result == 'success') {
                            // Refresh the table
                            // var oTable = $('#tModuleListing').dataTable();
                            table.draw();
                        }
                        else {
                            alert('Failed to Delete item - ' + data.message);
                        }

                    },
                    error: function () {
                        alert('Failed to Delete item - unexpected error');
                        // todo: add proper error message
                    }
                });
            }



        return true;

        } );

        // Search the table from the external search textbox. Limit to search string > 3 characters
        $('#searchbox').on( 'keyup', function () {
           if (($("#searchbox").val().length > 2) || ($("#searchbox").val().length == 0)) {
                table.search( this.value ).draw();
           }

        } );

        $("[data-toggle=popover]").popover({
            html: true,
        	content: function() {
                  return $('#popover-content').html();
                }
        });

        //TODO : Reload data for advanced search.

        $(document).on('submit','#searchform',function(){
            $("#searchmode").val("Y");
            alert($("#searchmode").val());

            table.ajax.url("{$data_url}");
            table.draw();
            return false;
        });

    
    
EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>