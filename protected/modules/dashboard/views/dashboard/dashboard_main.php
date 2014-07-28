<style>
<!--
#dashboard {
    background:#fff;
}
-->
</style>

        <div id="dashboard">

            <div class="container">
                <div class="row">
                    <div class="col-sm-10">
                        <h1>Dashboard : <?php echo CHtml::encode(Yii::app()->user->getFullName()); ?></h1>
                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>

                <div class='row'>
                    <div class="col-sm-12">
                        <div id="statusMsg">
                        <?php if(Yii::app()->user->hasFlash('success')):?>
                            <div class="flash-success">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(Yii::app()->user->hasFlash('error')):?>
                            <div class="flash-error">
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <?php $this->renderPartial('panels/'.$configDashboard['leftpanel'], array('data' => $configDashboard['data'])); ?>
                    </div>


                    <!--/col-3-->
                    <div class="col-sm-9">

                        <?php $this->renderPartial('panels/'.$configDashboard['mainpanel'], array('data' => $configDashboard['data'])); ?>

                    </div>
                    <!--/tab-content-->
                </div>
                <!--/col-9-->
            </div>
            <!--/row-->
        </div>

