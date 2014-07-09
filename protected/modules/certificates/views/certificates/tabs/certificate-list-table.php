<table class="table">
    <tr>
        <th>Certificate Number</th>
        <th>Allocation</th>
        <th>Purchase Date</th>
        <th>Certificate Value</th>
        <th>Unique Code</th>
        <th>Issued Date</th>
        <th>Redeemed By</th>
        <th>Redeemed Date</th>
        <th class="button-column"></th>
    </tr>

<?php foreach($data as $row) { ?>
        <tr>
            <td><?php echo CHtml::encode($row['certificate_number']); ?></td>
            <td><?php echo CHtml::encode($row->business['business_name']);  ?></td>
            <td><?php echo CHtml::encode($row['purchased_by_business_date']); ?></td>
            <td><?php echo CHtml::encode($row['certificate_value']); ?></td>
            <td><?php echo (!empty($row['redeem_code'])?CHtml::encode($row['redeem_code']):''); ?></td>
            <td><?php echo CHtml::encode($row['issue_date']); ?></td>
            <td><?php echo CHtml::encode($row->user['first_name'].' '.$row->user['last_name']) ?></td>
            <td><?php echo CHtml::encode($row['redeem_date']); ?></td>

            <?php if (!empty($row['redeem_code']) && (empty($row['redeem_date']))) { ?>
                        <td><a href="<?php echo $this->createUrl('/certificates/certificates/issue', array('id'=>$row['certificate_id'])); ?>" class="btn btn-primary btn-xs">Re-issue</button></a>
            <?php }
                  else if (!empty($row['redeem_code']) && (!empty($row['redeem_date']))) { ?>
                        <td>&nbsp;</a>
            <?php }
                  else { ?>
                        <td><a href="<?php echo $this->createUrl('/certificates/certificates/issue', array('id'=>$row['certificate_id'])); ?>" data-id="<?php echo $row['redeem_code']; ?>" class="btn btn-primary btn-xs allocate-btn">Issue</button></a>
            <?php } ?>
        </tr>
<?php } ?>

</table>


<?php
    if($pageCount > 1) {
?>

<ul class="pager" id="cert-list-pagination">
    <?php
        for($i = 1; $i <= $pageCount; $i++) {
    ?>
    <li><a href="#" data-page="<?php echo $i?>"><?php echo $i?></a></li>
    <?php
        }
    ?>
</ul>

<?php
    }
?>

