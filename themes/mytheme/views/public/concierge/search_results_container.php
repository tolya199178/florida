    <div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default margin-top-10">
				<div class="panel-heading">
					<h3>Featured guesthouse destinations</h3>
				</div>

				<div class="row margin-top-10">

                    <?php

                        foreach ($model as $objBusiness)
                        {
                            $this->renderPartial('result_business_entity', array('data'              => $objBusiness));
                        }

                    ?>

				</div>
			</div>
		</div>
    </div>

    <div class="row">

            <?php

                $this->renderPartial('result_event_details', array('data' => $listEvent));

            ?>
    </div>