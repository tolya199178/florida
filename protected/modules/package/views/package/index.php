<style>
<!--
#packages {
    background:#fff;
}

#packages .package {
    margin: 10px;
    padding: 5px;
}

#packages .package-select {
    position: absolute;
    top: 5px;
    left: 5px;
}

#packages .unselected {
    border: 1px solid #555555;
}

#packages .selected {
    border: 1px solid #ff0000;
}

#packages .buttons {
    text-align: center;
}

#packages .package .package-content {
    display: table;
}

#packages .thumbnail {
    display: table-cell;
    width: 150px;
    border: none;
}

#packages .description {
    display: table-cell;
    vertical-align: top;
}

</style>

<div id="packages">
    <form id="packages-form" action="<?php echo $this->createUrl('package/cart')?>" method="post">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Packages</h1>
                </div>
            </div>

            <div class="container" id="package_listing_container">

            </div>

            <div class="row">
                <div class="col-sm-12 buttons">
                    <?php echo CHtml::dropDownList('business_id', '', $businessOptions)?><br>
                    <a href="#" class="btn btn-primary btn-md buy">BUY</a>
                </div>
            </div>
        </div>
    </form>
</div>


<?php

$baseUrl = $this->createAbsoluteUrl('/');

$showlistingUrl = $baseUrl.'/package/package/showlisting';

$script = <<<EOD

// /////////////////////////////////////////////////////////////////////////////
// Package Listing
// /////////////////////////////////////////////////////////////////////////////
    var page = 0;

    function loadnewdata()
    {
        // do ajax stuff, update data.
         var url         = '$showlistingUrl'+'/page/'+page;

         $.ajax({ url: url,
                  cache: false,
                  success: function(data){
                        
                        if(data == '') {
                            clearInterval(pagingInterval);
                            return;
                        }
                  
                        $('#package_listing_container').append(data);

                        page++;
                  },
                  dataType: "html"
                });
    }

    var pagingInterval = setInterval(
      function (){
        if(($(document).height() - $(window).height() - $(document).scrollTop()) < 500){
    	   loadnewdata();
        }
      },
      500
    );

    // Run the initial listing load.
 	loadnewdata();
       
        
/////////////////////////////////
// Item select unselect
////////////////////////////////
        
    $('body').on('click', '#packages .package', function(event) {
        var block = $(this);
        var checkbox = block.find('.package-select-input');
        if(checkbox.prop('checked')) {
            block.removeClass('selected');
            block.addClass('unselected');
            checkbox.prop('checked', false);
        } else {
            block.removeClass('unselected');
            block.addClass('selected');
            checkbox.prop('checked', true);
        }
    });
        
    $('body').on('click', '#packages .buy', function(event) {
        if($('#packages .selected').length > 0) {
            $('#packages-form').submit();
        }
        return false;
    });

EOD;

Yii::app()->clientScript->registerScript('biz_listing', $script, CClientScript::POS_READY);

?>