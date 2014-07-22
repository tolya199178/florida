<?php 
    foreach($packageList as $package) {
        $this->renderPartial('package-item', array('package' => $package, 'selectable' => true));
    }
?>
