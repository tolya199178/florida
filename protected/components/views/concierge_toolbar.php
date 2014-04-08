        <div id="concierge_toolbar">
             <div>Popular Acivities</div>
             <div class="btn-toolbar" role="toolbar" style="margin: 0;">
<?php        foreach ($listActivitySearch as $searchLogEntry) { ?>
                    <button type="button" class="btn btn-sm btn-primary"><?php echo $searchLogEntry['search_tag']; ?></button>
<?php        } ?>
             </div>
             <div>Popular Types</div>
             <div class="btn-toolbar" role="toolbar" style="margin: 0;">
<?php        foreach ($listCategorySearch as $searchLogEntry) { ?>
                    <button type="button" class="btn btn-sm btn-warning"><?php echo $searchLogEntry['search_tag']; ?></button>
<?php        } ?>
                    <button type="button" class="btn btn-sm btn-warning">Chinese</button>
                    <button type="button" class="btn btn-sm btn-warning">Italian</button>
                    <button type="button" class="btn btn-sm btn-warning">Take Aways</button>
             </div>

        </div>
