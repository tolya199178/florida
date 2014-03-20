<?php 

//print_r($data->attributes);


?>

<li>
    <div class="box article"  style="float: left;">
        <div  style="float: left;width: 100%">
            <h4>
                <?php echo CHtml::link($data->business_name, $data->business_name, array('title' => $data->business_name)); ?>
            </h4>
            <!-- for save -->
            <div class="pull-right">
                <?php
//                 if (Yii::app()->user->id) {
//                     $favImg = "img/add.png";
//                     $reCmdImg = "img/active.jpg";
//                     $favHtml = array(
//                         'id' => "favclik{$data->buns_id}",
//                         'title' => 'Click to add this business',
//                         'onClick' => "savefavbusiness({$data->buns_id})",
//                         'width' => '20px', 'height' => '20px'
//                     );
//                     $reCmdHtml = array('id' => "recmdclik{$data->buns_id}",
//                         'title' => 'Click to recommended this business',
//                         'onClick' => "reCmdBns({$data->buns_id})",
//                         'width' => '20px', 'height' => '20px'
//                     );
//                     $reComBns = UserRecomendBusiness::chkBnsAdded($data->buns_id, Yii::app()->user->id);
//                     if (count($reComBns)) {
//                         $favImg = "img/added.png";
//                         $reCmdImg = $reComBns->is_recomend ? "img/actived.jpg" : $reCmdImg;
//                         $favHtml['title'] = '';
//                         unset($favHtml['onClick']);
//                         if ($reComBns->is_recomend) {
//                             unset($reCmdHtml['onClick']);
//                             $reCmdHtml['title'] = '';
//                         }
//                     }
//                     $favImg = Yii::app()->mclass->img($favImg, 16, 16);
//                     $reCmdImg = Yii::app()->mclass->img($reCmdImg, 16, 16);
//                     $favImg = CHtml::image($favImg, 'Fav', array('width' => '20px', 'height' => '20px'));
//                     $reCmdImg = CHtml::image($reCmdImg, 'Recomend', array('width' => '20px', 'height' => '20px'));
//                     echo CHtml::link($favImg, MConst::URL_EMPTY, $favHtml);
//                     echo CHtml::link($reCmdImg, MConst::URL_EMPTY, $reCmdHtml);
//                 }
                ?>
            </div>
            <!-- for save -->
        </div>
        <figure  style="float: left;width:275px; height:150px;">
            <?php
//             $src = strpos($data->cmpny_img, 'http') !== false ? $data->cmpny_img : "/" . MConst::BUSS_IMG . $data->cmpny_img;
//             $tsrc = "/img/loader.gif";
//             $bnsImg = CHtml::image($tsrc, $data->cmpny_keyword, array('class' => "lazy result_bns_img", 'data-original' => $src, 'width' => '275px', 'height' => '150px'));
//             echo CHtml::link($bnsImg, MConst::URL_EMPTY, array('onClick' => "businessdls({$data->buns_id})"))
            ?>
        </figure>
        <?php
//         $profURL = isset($data->user->UProf->usr_profile_pic) ? $data->user->UProf->usr_profile_pic : "avatar.png";
//         $profURL = "/" . MConst::PROF_IMG . $profURL;
//         echo CHtml::image($profURL, 'USER', array('class' => "avatar"));
        ?>
        <div class="bp_bottom_tex">
            <p style="float: left;">
                <?php
//                 $txt = "<del>Your Price $" . $data->bImport->PRICE . "</del> <span style='color: red'> $" . $data->bImport->RETAILPRICE . "</span>";
//                 echo CHtml::link($txt, $likUrl, array('target' => '_blank'));
                ?>
            </p>
            <p><?php echo $data->business_name; ?> </p>
        </div>
        <span class="small-tags" >
            <?php
//             //Need to optimize
//             $tag = Type::getTags($data->buns_id);
//             if (count($tag)) {
//                 foreach ($tag as $value) {
//                     ? >
//                    <span class="label"><?php echo $value; ? > </span>
//                    < ? php
//                 }
//             }
            ?>
        </span>
    </div>
</li>
