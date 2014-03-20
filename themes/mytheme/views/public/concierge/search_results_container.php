<div class="row">
    <div class="col-lg-12">
    
    <?php

    $this->widget('zii.widgets.CListView', array(
        'id' => 'bizprofiles',
        'dataProvider' => $dataProvider,
        'viewData' => array('type' => 'biz', 'blah' => 123),
        'itemView' => 'result_business_entity',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'unstyled results',
        //'template' => '{pager}{items}',
        'emptyText' => '<label class="heading">No Business available !</label>',
//         'afterAjaxUpdate' => 'js:function(id) {
//               $("#bnsprofile img.lazy").show().lazyload({effect: "fadeIn"});
//              }',
    ));
    ?>
    </div>