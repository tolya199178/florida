<style>
<!--

.review_text {
font-style:italic;
}

.review_rating {
color:red;
font-size:15px;
}
-->
</style>

<h3>Other Reviews :</h3><br/>

<?php   foreach ($model->businessReviews as $businessReview) { ?>

        <div class='row'>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class='review_rating'><?php echo str_repeat('<span class="glyphicon glyphicon-star">&nbsp;</span>', (int) $businessReview['rating']); ?></div>
                </div>
                <div class="col-lg-12">
                    <div class='review_text'><?php echo CHtml::encode($businessReview['review_text']); ?></div>
                </div>
                <div class="col-lg-12">
                    <div class='review_date'>Reviewed on: <?php echo date('D M jS, Y', strtotime($businessReview['review_date'])); ?></div>
                    by <div class='review_user'><?php echo $businessReview->user->first_name . ' ' . $businessReview->user->last_name; ?></div>
                </div>
            </div>
            <hr/>
        </div>

<?php } ?>

