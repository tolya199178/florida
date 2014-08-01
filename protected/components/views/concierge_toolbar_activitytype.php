<?php       if (count($listCategorySearch) > 0) { ?>
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col">
            <div>Popular Types</div>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col">
            <div class="btn-toolbar" role="toolbar" style="margin: 0;padding-bottom:1px;">
<?php       foreach ($listCategorySearch as $searchLogEntry) { ?>
                <button type="button" class="btn btn-sm btn-warning concierge_activitytype_tag" rel=<?php echo $searchLogEntry['activity_id']; ?>><?php echo CHtml::encode($searchLogEntry['keyword']); ?></button>
<?php       } ?>
            </div>

        </div>

    </div>
<?php       } ?>
