    <div id="myCarousel" class="carousel slide" data-interval="4000" data-ride="carousel">
    	<!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <?php foreach ($lstCityPhotos as $index => $cityPhoto ) { ?>
                <li data-target="#myCarousel" data-slide-to="<?php echo $index; ?>" <?php echo ($index==0)?'class="active"':''; ?>></li>
            <?php } ?>
        </ol>
       <!-- Carousel items -->
        <div class="carousel-inner">
            <?php foreach ($lstCityPhotos as $index => $cityPhoto ) { ?>
                <div class="<?php echo ($index==0)?'active':''; ?> item">
                    <h2>
                    <?php echo CHtml::image($cityPhoto->path, CHtml::encode($cityPhoto->path)); ?>
                    </h2>
                    <div class="carousel-caption">
                      <h3><?php echo CHtml::encode($cityPhoto->title); ?></h3>
                      <p><?php echo CHtml::encode($cityPhoto->caption); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Carousel nav -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>