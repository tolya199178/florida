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

<div class='row'>
    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class='review_rating'><?php echo str_repeat('<span class="glyphicon glyphicon-star">&nbsp;</span>', (int) $model->rating); ?></div>
        </div>
        <div class="col-lg-12">
            <div class='review_text'><?php echo CHtml::encode($model->review_text); ?></div>
        </div>
        <div class="col-lg-12">
            <div class='review_date'>Reviewed on: <?php echo date('D M jS, Y', strtotime($model->review_date)); ?></div>
        </div>
    </div>
    <hr/>
</div>

