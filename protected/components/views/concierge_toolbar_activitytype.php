<?php       if (count($listCategorySearch) > 0) { ?>
                <div>Popular Types</div>
                    <div class="btn-toolbar" role="toolbar" style="margin: 0;">
<?php               foreach ($listCategorySearch as $searchLogEntry) { ?>
                        <button type="button" class="btn btn-sm btn-warning concierge_activitytype_tag"><?php echo $searchLogEntry['keyword']; ?></button>
<?php               } ?>
                </div>
<?php       } ?>
