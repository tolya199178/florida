
    <div id='last_timestamp' style='display:none;'><?php  echo time(); ?></div>

    <div id='feedresult'>
            <?php foreach ($model as $value) { ?>
                <?php

                    $search_results = unserialize($value->search_details);

                    $doWhat                     = CHtml::encode($search_results['dowhat']);
                    $doWithWhat                 = CHtml::encode($search_results['withwhat']);
                    $doWhere                    = CHtml::encode($search_results['where']);

                    if (Yii::app()->user->isGuest) {
                        $searchUserImage        = Yii::app()->theme->baseUrl."/resources/images/anon_user.png";
                        $searchUserName         = 'Someone';
                        $searchUserFullName     = 'Someone';
                        $searchUserLocation     = CHtml::encode($search_results['where']);
                    }
                    else
                    {
                        // Anonymous user searches are logged with userid = 1
                        if ($value->user->user_id == 1)
                        {
                            $searchUserImage    = Yii::app()->theme->baseUrl."/resources/images/anon_user.png";
                            $searchUserName     = 'Someone';
                            $searchUserFullName = 'Someone';
                            $searchUserLocation = CHtml::encode($search_results['where']);
                        }
                        else
                        {

                            if (!empty($value->user->image))
                            {
                                if(filter_var($value->user->image, FILTER_VALIDATE_URL))
                                {
                                    $searchUserImage = $value->user->image;
                                }
                                else
                                {
                                    if (file_exists(Yii::getPathOfAlias('webroot').'/uploads/images/user/'.$value->user->image))
                                    {
                                        $searchUserImage = Yii::app()->request->baseUrl .'/uploads/images/user/'.$value->user->image;
                                    }
                                    else
                                    {
                                        $searchUserImage   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                                    }
                                }
                            }
                            else
                            {
                                $searchUserImage   = Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH'];
                            }

                            $searchUserName     = CHtml::link($value->user->first_name, Yii::app()->createUrl('/webuser/profile/show'), array('id' => $value->user->user_id));
                            $searchUserFullName = CHtml::encode($value->user->first_name).' '.CHtml::encode($value->user->last_name);
                            $searchUserLocation = '';
                        }
                    }

                ?>
                <div class="row">

                    <div class=col-lg-2>
                        <?php
                            echo CHtml::image($searchUserImage, $searchUserFullName, array('width'=>50, 'height'=>50));
                        ?>
                    </div>
                    <div class="col-lg-10">
                        <p>
                            <?php echo $searchUserName;?>
                            <?php echo (!empty($searchUserLocation)?' from '.$searchUserLocation:'');?>
                            searched for <br/>
                            <?php echo $doWhat.' '.$doWithWhat. ' in ' .$doWhere; ?>
                        </p>
                        <p><small><time class="timeago" datetime="<?php echo $value->created_time; ?>"></time></small> </p>
                    </div>
                </div>
                <hr/>
            <?php } ?>
    </div>

