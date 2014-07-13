<style>

/* Fix Google Maps canvas
 *
 * Wrap your Google Maps embed in a `.google-map-canvas` to reset Bootstrap's
 * global `box-sizing` changes. You may optionally need to reset the `max-width`
 * on images in case you've applied that anywhere else. (That shouldn't be as
 * necessary with Bootstrap 3 though as that behavior is relegated to the
 * `.img-responsive` class.)
 */

.google-map-canvas,
.google-map-canvas * { .box-sizing(content-box); }

.map_canvas,
.map_canvas * { .box-sizing(content-box); }

/* Optional responsive image override */
img { max-width: none; }

</style>


<?php if ( (!empty($model->latitude)) && (!empty($model->longitude)) ) { ?>
<input type="hidden" id="map_latitude" value="<?php echo $model->latitude; ?>" />
<input type="hidden" id="map_longitude" value="<?php echo $model->longitude; ?>" />
<?php } ?>

    <div class="col-sm-12">
        <div id='map_canvas'>&nbsp;<!-- MAP HERE --></div>
    </div>