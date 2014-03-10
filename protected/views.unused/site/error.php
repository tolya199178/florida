
<h2>
    Error  < ? = $ error['code']; ? >
</h2>
<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>
<div class="row">
    <div class="span4">
        <div class="alert">
            <a class="close" data-dismiss="alert">×</a> <strong>Warning!</strong>
            <?php echo CHtml::encode($$message); ?>
        </div>
    </div>
</div>
