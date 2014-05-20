    <div class="row">

<?php   if (count($model) > 0) { ?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default margin-top-10">
				<div class="panel-heading">
					<h3>Featured Business</h3>
				</div>

				<div class="row margin-top-10">

                    <?php

                        foreach ($model as $objBusiness)
                        {
                            $this->renderPartial('result_business_entity', array('data' => $objBusiness));
                        }

                    ?>

				</div>
			</div>
		</div>
<?php   }
        else { ?>
        <h4>No matching businesses found</h4>
<?php   } ?>

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
