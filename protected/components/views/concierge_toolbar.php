    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col">
             <div>Popular Acivities</div>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col">
            <div id="concierge_toolbar">
                <div class="btn-toolbar" role="toolbar" style="margin: 0;padding-bottom:1px;" id='concierge_toolbar_activity'>
<?php           foreach ($listActivitySearch as $searchLogEntry) { ?>
                    <button type="button" class="btn btn-sm btn-primary concierge_activity_tag" rel="<?php echo $searchLogEntry['search_summary_id']; ?>"><?php echo $searchLogEntry['search_tag']; ?></button>
<?php           } ?>
                </div>
            </div>
        </div>
    </div>
    <div id='concierge_toolbar_activitytype'>
    </div>

