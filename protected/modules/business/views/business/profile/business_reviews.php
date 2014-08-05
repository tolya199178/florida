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

        <!-- Rating -->
        <div class="col-lg-12">
            <h3>Reviews :</h3><br/>
<?php if (!(Yii::app()->user->isGuest)) { ?>
            <button class="pop-review-form btn btn-md btn-info" rel="review_popover" refid="<?php echo (int) $model->business_id; ?>"  >Your Review</button>

            <!-- Review form popup -->
            <div class="row" id="review-box" style="display:none;">
                <div class="col-md-12">
                    <form accept-charset="UTF-8" action="" method="post" id='review_form'>
                        <input type='hidden' id="review_business_id" name="review_business_id" value="<?php echo (int) $model->business_id; ?>">
                        <textarea class="form-control animated" cols="50" id="review_text" name="review_text" placeholder="Enter your review here..." rows="5"></textarea>

                        <span><input type="number" name="review_rating" id="review_rating"  class="review_rating" value='' /></span>

                        <div class="text-right">
                            <button class="close-review btn btn-error btn-lg" type="reset">Cancel</button>
                            <button class="btn btn-success btn-lg" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.Review form popup -->
<?php } ?>

<h3>What others are saying :</h3><br/>

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
        </div>

