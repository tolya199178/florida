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
<?php foreach ($model as $modelEvent) { ?>
<div class='row'>
    <div class="col-lg-12">

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->event_id), array('view', 'id'=>$data->event_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_title')); ?>:</b>
    <?php echo CHtml::encode($data->event_title); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_description')); ?>:</b>
    <?php echo CHtml::encode($data->event_description); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_type')); ?>:</b>
    <?php echo CHtml::encode($data->event_type); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_start_date')); ?>:</b>
    <?php echo CHtml::encode($data->event_start_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_end_date')); ?>:</b>
    <?php echo CHtml::encode($data->event_end_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_start_time')); ?>:</b>
    <?php echo CHtml::encode($data->event_start_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_end_time')); ?>:</b>
    <?php echo CHtml::encode($data->event_end_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_frequency')); ?>:</b>
    <?php echo CHtml::encode($data->event_frequency); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_address1')); ?>:</b>
    <?php echo CHtml::encode($data->event_address1); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_address2')); ?>:</b>
    <?php echo CHtml::encode($data->event_address2); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_street')); ?>:</b>
    <?php echo CHtml::encode($data->event_street); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_city_id')); ?>:</b>
    <?php echo CHtml::encode($data->event_city_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_phone_no')); ?>:</b>
    <?php echo CHtml::encode($data->event_phone_no); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_show_map')); ?>:</b>
    <?php echo CHtml::encode($data->event_show_map); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_photo')); ?>:</b>
    <?php echo CHtml::encode($data->event_photo); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_category_id')); ?>:</b>
    <?php echo CHtml::encode($data->event_category_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_business_id')); ?>:</b>
    <?php echo CHtml::encode($data->event_business_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_latitude')); ?>:</b>
    <?php echo CHtml::encode($data->event_latitude); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_longitude')); ?>:</b>
    <?php echo CHtml::encode($data->event_longitude); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_tag')); ?>:</b>
    <?php echo CHtml::encode($data->event_tag); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
    <?php echo CHtml::encode($data->created_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
    <?php echo CHtml::encode($data->modified_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
    <?php echo CHtml::encode($data->created_by); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
    <?php echo CHtml::encode($data->modified_by); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('is_featured')); ?>:</b>
    <?php echo CHtml::encode($data->is_featured); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('is_popular')); ?>:</b>
    <?php echo CHtml::encode($data->is_popular); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_status')); ?>:</b>
    <?php echo CHtml::encode($data->event_status); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
    <?php echo CHtml::encode($data->cost); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('event_views')); ?>:</b>
    <?php echo CHtml::encode($data->event_views); ?>
    <br />

    </div>
    <hr/>
</div>
<?php } ?>


