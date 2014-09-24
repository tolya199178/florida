
    <h2>Business Categories</h2>




        <!--panel-->
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Buniness Category Listing</div>
            <div class="panel-body">

            <?php foreach ($lstBusinesCountPerCategory as $itemCategory)     {  ?>

                <!--Category list-->

                <a class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('/business/business/claim', array('category_id' => $itemCategory['category_id']  )); ?>">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                    <?php echo $itemCategory['category_name']; ?> (<?php echo $itemCategory['business_count']; ?>)

                </a>

            <?php  } ?>
            </div>
        </div>
        <!--end of panel-->
        <br/>



