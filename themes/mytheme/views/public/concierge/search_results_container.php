    <div class="row">
        
            <?php
        
            $this->widget(  'zii.widgets.CListView', array(
                            'id'            => 'bizprofiles',
                            'dataProvider'  => $dataProvider,
                           // 'viewData'      => array('type' => 'biz', 'blah' => 123),
                            'itemView'      => 'result_business_entity',
                            'itemsTagName'  => 'div',
                            'itemsCssClass' => 'row',
                             // NOTE: We may not need this 'template'    => '{pager}{items}',
                            'emptyText'     => '<label class="heading">No Business available !</label>',
    
            ));
            ?>
    </div>