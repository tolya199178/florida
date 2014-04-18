        <div id="concierge_toolbar">
             <div>Popular Acivities</div>
             <div class="btn-toolbar" role="toolbar" style="margin: 0;" id='concierge_toolbar_activity'>
<?php        foreach ($listActivitySearch as $searchLogEntry) { ?>
                    <button type="button" class="btn btn-sm btn-primary concierge_activity_tag" rel="<?php echo $searchLogEntry['search_summary_id']; ?>"><?php echo $searchLogEntry['search_tag']; ?></button>
<?php        } ?>
             </div>
             <div class="btn-toolbar" role="toolbar" style="margin: 0;" id='concierge_toolbar_activitytype'>
             </div>
         </div>

