<style>
.thumbnail {
    position:relative;
    overflow:hidden;
}

.caption {
    position:absolute;
    top:0;
    right:0;
    background:rgba(66, 139, 202, 0.75);
    width:100%;
    height:100%;
    padding:2%;
    display: none;
    text-align:center;
    color:#fff !important;
    z-index:2;
}
</style>

<style>
@import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);
.col-item
{
    border: 1px solid #E1E1E1;
    border-radius: 5px;
    background: #FFF;
}
.col-item .photo img
{
    margin: 0 auto;
    width: 100%;
}

.col-item .info
{
    padding: 10px;
    border-radius: 0 0 5px 5px;
    margin-top: 1px;
}

.col-item:hover .info {
    background-color: #F5F5DC;
}
.col-item .price
{
    /*width: 50%;*/
    float: left;
    margin-top: 5px;
}

.col-item .price h5
{
    line-height: 20px;
    margin: 0;
}

.price-text-color
{
    color: #219FD1;
}

.col-item .info .rating
{
    color: #777;
}

.col-item .rating
{
    /*width: 50%;*/
    float: left;
    font-size: 17px;
    text-align: right;
    line-height: 52px;
    margin-bottom: 10px;
    height: 52px;
}

.col-item .separator
{
    border-top: 1px solid #E1E1E1;
}

.clear-left
{
    clear: left;
}

.col-item .separator p
{
    line-height: 20px;
    margin-bottom: 0;
    margin-top: 10px;
    text-align: center;
}

.col-item .separator p i
{
    margin-right: 5px;
}
.col-item .btn-add
{
    width: 50%;
    float: left;
}

.col-item .btn-add
{
    border-right: 1px solid #E1E1E1;
}

.col-item .btn-details
{
    width: 50%;
    float: left;
    padding-left: 10px;
}
.controls
{
    margin-top: 20px;
}
[data-slide="prev"]
{
    margin-right: 10px;
}

</style>



<!--  Business search results -->
<div class="container">

    <div class="row">
<?php
        if (count($model) > 0) {
            foreach ($model as $objBusiness)
            {
                $this->renderPartial('result_business_entity', array('data' => $objBusiness));
            }
        }
        else {
?>
            <h4>No matching businesses found</h4>
<?php   } ?>

    </div>
</div>
<!--  ./Business search results -->

    <div class="row">


<?php   if (count($listEvent) > 0) { ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default margin-top-10">
				<div class="panel-heading">
					<h3>Featured Events</h3>
				</div>

				<div class="row margin-top-10">

                    <?php
                        // $this->renderPartial('result_event_details', array('data' => $listEvent));

                        foreach ($listEvent as $eventItem)
                        {
                            $this->renderPartial('result_event_details', array('eventItem' => $eventItem));
                            // $this->renderPartial('result_business_entity', array('data'              => $objBusiness));
                        }
                    ?>

				</div>
			</div>
		</div>
<?php   }
        else { ?>
        <h4>No matching events found</h4>
<?php   } ?>
    </div>
