<?php
/**
 * @package default
 */
$baseScriptUrl = $this->createAbsoluteUrl('/');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/js/vendor/typeahead/typeahead.bundle.js', CClientScript::POS_END);
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

.twitter-typeahead .tt-query,
.twitter-typeahead .tt-hint {
  margin-bottom: 0;
}

.tt-dropdown-menu {
  min-width: 160px;
  margin-top: 2px;
  padding: 5px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0,0,0,.2);
  *border-right-width: 2px;
  *border-bottom-width: 2px;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
  -webkit-background-clip: padding-box;
     -moz-background-clip: padding;
          background-clip: padding-box;
}

.tt-suggestion {
  display: block;
  padding: 3px 20px;
}

.tt-suggestion.tt-is-under-cursor {
  color: #fff;
  background-color: #0081c2;
  background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
  background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
  background-image: -o-linear-gradient(top, #0088cc, #0077b3);
  background-image: linear-gradient(to bottom, #0088cc, #0077b3);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0077b3', GradientType=0)
}

.tt-suggestion.tt-is-under-cursor a {
  color: #fff;
}

.tt-suggestion p {
  margin: 0;
}
   

-->
</style>
<?php
    $data_url = Yii::app()->createUrl('concierge/prefecthlistall');
    echo $data_url;
    
$script = <<<EOD

var numbers = new Bloodhound({
  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.city_name); },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {url: '{$data_url}'}
});
 
// initialize the bloodhound suggestion engine
numbers.initialize();
 
// instantiate the typeahead UI
$('#city').typeahead(null, {
  displayKey: 'city_name',
  source: numbers.ttAdapter()
});
      
    
EOD;
    
    Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);
    
?>


<div class="row">
    <div class="col-lg-3">
        <div id="sidebar"  >
            <div class="alert alert-warning">
                <p>Follow friends and curators their lookup search here! </p>
                <p class="pagination-centered"><a href="#" class="btn btn-info">Follow</a></p>
            </div>
      
        </div>
    </div>
        
    <div class="col-lg-9" style="">
            <div id="mainpanel"  >
                This is the mainpanel and ir grows
                <div class="row">
                    <div class="col-lg-4" style="">
                        I AM IN 
                        <input id="city" class="typeahead form-control" type="text" placeholder="City">
                    </div>
                    
                    <div class="col-lg-8" style="">
                        I WANT TO
                        
        <div class="label-query-interested">
            <label for="slt_city" class="heading">I am IN</label>
            <?php
            $data = City::getCity();
            echo Chosen::dropDownList('slt_city', $defaultCity->city_id, $data, array('onChange' => "changeLocation(this.value);", 'class' => 'cls_slt_city'));
            echo CHtml::hiddenField('where_hidden', $defaultCity->city_id);
            echo CHtml::hiddenField('interest_hidden', $interest);
            echo CHtml::hiddenField('what_hidden', $what);
            echo CHtml::hiddenField('when_hidden', $when);
            ?>
            <label for="" class="heading">I want to</label>
        </div>



                    </div>
                    
                </div>
                
            
            </div>
    
  
    </div>
</div>