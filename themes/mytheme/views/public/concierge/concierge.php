<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/js/vendor/typeahead/typeahead.bundle.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/bootstrap-tagsinput/bootstrap-tagsinput.css');

?>
<style>
<!--
#sidebar
{
  background-color: white;
  text-align: left;
  position: fixed;
  top: 66px;
  bottom: 3px;
/*   left: 0px; */
/*   width: 23.4043%; */
  padding-top: 10px;
  padding-right: 10px;
  padding-bottom: 10px;
  padding-left: 10px;
  box-shadow: #b0b0b0;
  z-index: 20;
}

#mainpanel {
  background-color: white;
  text-align: left;
  position: fixed;
  top: 66px;
  bottom: 3px;
/*   left: 0px; */
   width: 74%;
  padding-top: 10px;
  padding-right: 10px;
  padding-bottom: 10px;
  padding-left: 10px;
  box-shadow: #b0b0b0;
  z-index: 21; 
   
}

.rightpanel {
  background-color: yellow;
   bottom: 3px;
}

.typeahead,
.tt-query,
.tt-hint {
  width: 250px;
/*   height: 30px; */
  padding: 8px 12px;
/*   font-size: 24px; */
/*   line-height: 30px; */
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}

.typeahead {
  background-color: #fff;
}

.typeahead:focus {
  border: 2px solid #0097cf;
}

.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-dropdown-menu {
  width: 250px;
  margin-top: 12px;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
  padding: 3px 20px;
/*   font-size: 18px; */
  line-height: 24px;
}

.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;

}

.tt-suggestion p {
  margin: 0;
}
   
.cities {
   float:right;
}

.activities {
   float:right;
}

#city {
  min-width: 250px;
}


-->
</style>
<?php

$local_list = City::model()->getListjson();
        
$script = <<<EOD

// Load the city list for type ahead
var numbers = new Bloodhound({
  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.city_name); },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   local: {$local_list}
});
 
// initialize the bloodhound suggestion engine
numbers.initialize();
 
// instantiate the typeahead UI
$('.cities .typeahead').typeahead(null, {
  displayKey: 'city_name',
  source: numbers.ttAdapter()
});

    
  function doSearch() {
    var dowhat      = $("#dowhat").val();
    var withwhat    = $("#withwhat").val();
    
    var url         = '/concierge/dosearch/dowhat/'+dowhat+'/withwhat/'+withwhat;
    alert(url);
    
      $.get(url,function(data,status){
        alert("Data: " + data + "Status: " + status);
      });

  }

    $('#dowhat').tagsinput({
    maxTags: 1
    });
    
    $('#withwhat').tagsinput({
    maxTags: 1
    });
    
    $("#dowhat").on("change", function() {
      alert($("#dowhat").val());
        doSearch()
    });

    $("#withwhat").on("change", function() {
      alert($("#withwhat").val());
    });
    
    

    
EOD;
    
Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);
    
?>


<div class="row">
    <div class="col-lg-3">
        <div id="sidebar"  >
            <div class="alert alert-warning"">
                <p>Follow friends and curators their lookup search here! </p>
                <p class="pagination-centered"><a href="#" class="btn btn-info">Follow</a></p>
            </div>
        </div>
    </div>
        
    <div class="col-lg-9" style="">
            <div id="mainpanel"  >
                This is the mainpanel and ir grows
                <div class="row">
                    <div class="col-lg-4">
                        <label for="city" class="heading">I AM IN &nbsp;&nbsp;&nbsp;</label>
                        <div class="cities">
                            <input class="typeahead form-control" name="city" id="city"  type="text" autocomplete="off" value="" placeholder="I am in...">   
                        </div>
                    </div>
                    
                    <div class="col-lg-8">                        
                        <label for="dowhat" class="heading">I WANT TO &nbsp;&nbsp;&nbsp;</label>
                        <div class="activities">
                            <input class="form-control" name="dowhat" id="dowhat"  type="text" autocomplete="off" value="">
                            <input class="form-control" name="withwhat" id="withwhat"  type="text" autocomplete="off" value="">   
                        </div>

                    </div>
                    
                </div>
                
            
            </div>
    
  
    </div>
</div>