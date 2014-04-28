
    <div id='last_timestamp' style='display:none;'><?php  echo time(); ?></div>

    <div id='feedresult'>
            <?php foreach ($model as $value) { ?>
                <?php $search_results = unserialize($value->search_details); ?>
                <div class="row">

                    <div class=col-lg-2>
                        <?php

                            if (Yii::app()->user->isGuest) {
                                echo CHtml::image(Yii::app()->theme->baseUrl."/resources/images/anon_user.png", "Image", array('width'=>50, 'height'=>50));
                            }
                            else
                            {
                                echo CHtml::image($value->user->image, "Image", array('width'=>50, 'height'=>50));
                            }
                        ?>
                    </div>
                    <div class="col-lg-10">
                        <p>
                            <?php
                            if (Yii::app()->user->isGuest) {
                                echo 'Someone from '.CHtml::encode($search_results['where']);
                            }
                            else
                            {
                                echo CHtml::link($value->user->first_name, Yii::app()->createUrl('/webuser/profile/show'), array('id' => $value->user->user_id));
                            }

                            ?>
                            searched for <br/>
                            <?php
                            echo CHtml::encode($search_results['dowhat']). ' ' .
                                 CHtml::encode($search_results['withwhat']). ' in ' .
                                 CHtml::encode($search_results['where']);

                            ?>
                        </p>
                        <p><small><time class="timeago" datetime="<?php echo $value->created_time; ?>"></time></small> </p>
                    </div>
                </div>
                <hr/>
            <?php } ?>
    </div>

