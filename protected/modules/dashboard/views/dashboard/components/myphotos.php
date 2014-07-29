<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery.imgareaselect/scripts/jquery.imgareaselect.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery-image-crop/js/jquery.Jcrop.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery-image-crop/js/script.js', CClientScript::POS_END);

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery-image-crop/css/jquery.Jcrop.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/jquery.imgareaselect/css/imgareaselect-default.css');

?>

<style>

/* Image upload and crop */

/*     .container { */
/*     width: 1000px; */
/*     height: auto; */
/*     background: #ffffff; */
/*     border: 1px solid #cccccc; */
/*     border-radius: 10px; */
/*     margin: auto; */
/*     text-align: left; */
/*     } */
/*     .header { */
/*     padding: 10px; */
/*     } */
/*     .main_title { */
/*     background: #cccccc; */
/*     color: #ffffff; */
/*     padding: 10px; */
/*     font-size: 20px; */
/*     line-height: 20px; */
/*     } */
/*     .content { */
/*     padding: 50px 10px 10px 10px; */
/*     min-height: 100px; */
/*     text-align: center; */
/*     } */
    .upload_btn {
    background: #cccccc;
    color: #333333;
    border: 1px solid #999999;
    border-radius: 10px;
    font-size: 16px;
    line-height: 30px;
    font-weight: bold;
    display: inline-block;
    padding: 0 10px 0 10px;
    cursor: pointer;
    }
    #photo_container {
    padding: 50px 0 0 0;
    }
    .upload_btn:hover {
    background: #eaeaea;
    }
    /* footer --------------------------*/
/*     .footer { */
/*     padding: 10px; */
/*     text-align: right; */
/*     } */
/*     .footer a { */
/*     color: #999999; */
/*     text-decoration: none; */
/*     } */
/*     .footer a:hover { */
/*     text-decoration: underline; */
/*     } */

    /* popup --------------------------*/
    #popup_upload,
    #popup_crop {
    position: fixed;
    width: 400px;
    height: 600px;
    top: 0;
    left: 0;
    background: rgba(0, 0 ,0, 0.7);
    z-index: 99;
    text-align: center;
    display: none;
    overflow: auto;
    }
    .form_upload {
    width: 400px;
    height: 440px;
    border: 1px solid #999999;
    border-radius: 10px;
    background: #ffffff;
    color: #666666;
    margin: auto;
    margin-top: 160px;
    padding: 10px;
    text-align: left;
    position: relative;
    }
    .form_upload h2 {
    border-bottom: 1px solid #999999;
    padding: 0 0 5px 0;
    margin: 0 0 20px 0;
    }
    .upload_frame {
    width: 0;
    height: 0;
    display: none;
    }
    .file_input {
    width: 97%;
    background: #eaeaea;
    border: 1px solid #999999;
    border-radius: 5px;
    color: #333333;
    padding: 1%;
    margin: 0 0 20px 0;
    }
    #upload_btn {
    background: #cccccc;
    color: #333333;
    border: 1px solid #999999;
    border-radius: 10px;
    float: right;
    line-height: 20px;
    font-size: 14px;
    font-weight: bold;
    font-family: arial;
    display: block;
    padding: 5px;
    cursor: pointer;
    }
    #upload_btn:hover {
    background: #eaeaea;
    }
    .close {
    position: absolute;
    display: block;
    right: 10px;
    cursor: pointer;
    font-size: 20px;
    line-height: 16px;
    width: 18px;
    height: 18px;
    border: 1px solid #cccccc;
    border-radius: 5px;
    background: #F0F0F0;
    text-align: center;
    font-weight: bold;
    }
    .close:hover {
    background: #cccccc;
    }
    #loading_progress {
    float: left;
    line-height: 18px;
    padding: 8px 0 0 0;
    }
    #loading_progress img {
    float: left;
    margin: 0 5px 0 0;
    width: 16px !important;
    }
    .form_crop {
    width: auto;
    height: auto;
    display: inline-block;
    border: 1px solid #999999;
    border-radius: 10px;
    background: #ffffff;
    color: #666666;
    margin: auto;
    margin-top: 40px;
    padding: 10px;
    text-align: left;
    position: relative;
    }
    .form_crop h2 {
    border-bottom: 1px solid #999999;
    padding: 0 0 5px 0;
    margin: 0 0 20px 0;
    }
    #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
    }
    #crop_btn {
    background: #cccccc;
    color: #333333;
    border: 1px solid #999999;
    border-radius: 10px;
    float: right;
    line-height: 30px;
    font-size: 14px;
    font-weight: bold;
    font-family: arial;
    display: block;
    padding: 5px;
    margin: 10px 0 0 0;
    cursor: pointer;
    }
    #crop_btn:hover {
    background: #eaeaea;
    }
</style>

<style>

/* Image gallery listings */

      .photogallery ul {
          padding:0 0 0 0;
          margin:0 0 0 0;
      }
      .photogallery ul li {
          list-style:none;
          margin-bottom:25px;
      }
      .photogallery ul li img {
          cursor: pointer;
      }
      .modal-body {
          padding:5px !important;
      }
      .modal-content {
          border-radius:0;
      }
      .modal-dialog img {
          text-align:center;
          margin:0 auto;
      }
    .controls{
        width:50px;
        display:block;
        font-size:11px;
        padding-top:8px;
        font-weight:bold;
    }
    .next {
        float:right;
        text-align:right;
    }
      /*override modal for demo only*/
      .modal-dialog {
          max-width:500px;
          padding-top: 90px;
      }
      @media screen and (min-width: 768px){
          .modal-dialog {
              width:500px;
              padding-top: 90px;
          }
      }
/*       @media screen and (max-width:1500px){ */
/*           #ads { */
/*               display:none; */
/*           } */
/*       } */
  </style>

   <div class="container">
        <div class="row" style="text-align:center; border-bottom:1px dashed #ccc;  padding:0 0 20px 0; margin-bottom:40px;">
            <h3 style="font-family:arial; font-weight:bold; font-size:30px;">My Images</h3>
            <?php $this->renderPartial('//user_photos/new_image', array('model'=> new Photo)); ?>
        </div>

        <div class="photogallery">

        <ul class="row">

<?php   foreach ($myPhotos as $itemPhoto) { ?>
            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                <a href="#">
                    <?php echo CHtml::image(Yii::app()->request->baseUrl .'/uploads/images/user/'.$itemPhoto->attributes['path'], 'User Image', array('class'=>'img-responsive')); ?>
                </a>
            </li>
<?php }?>
        </ul>
        </div>


    </div> <!-- /container -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



<?php
$script = <<<EOD


        $('li img').on('click',function(){
            var src = $(this).attr('src');
            var img = '<img src="' + src + '" class="img-responsive"/>';

            //start of new code new code
            var index = $(this).parent('li').index();

            var html = '';
            html += img;
            html += '<div style="height:25px;clear:both;display:block;">';
            html += '<a class="controls next" href="'+ (index+2) + '">next &raquo;</a>';
            html += '<a class="controls previous" href="' + (index) + '">&laquo; prev</a>';
            html += '</div>';

            $('#myModal').modal();
            $('#myModal').on('shown.bs.modal', function(){
                $('#myModal .modal-body').html(html);
                //new code
                $('a.controls').trigger('click');
            })
            $('#myModal').on('hidden.bs.modal', function(){
                $('#myModal .modal-body').html('');
            });




       });


        //new code
        $(document).on('click', 'a.controls', function(){
            var index = $(this).attr('href');
            var src = $('ul.row li:nth-child('+ index +') img').attr('src');

            $('.modal-body img').attr('src', src);

            var newPrevIndex = parseInt(index) - 1;
            var newNextIndex = parseInt(newPrevIndex) + 2;

            if($(this).hasClass('previous')){
                $(this).attr('href', newPrevIndex);
                $('a.next').attr('href', newNextIndex);
            }else{
                $(this).attr('href', newNextIndex);
                $('a.previous').attr('href', newPrevIndex);
            }

            var total = $('ul.row li').length + 1;
            //hide next button
            if(total === newNextIndex){
                $('a.next').hide();
            }else{
                $('a.next').show()
            }
            //hide previous button
            if(newPrevIndex === 0){
                $('a.previous').hide();
            }else{
                $('a.previous').show()
            }


            return false;
        });




EOD;

Yii::app()->clientScript->registerScript('gallery_view', $script, CClientScript::POS_READY);

?>


<?php

$script = <<<EOD

    $("body").on('submit', "#frmuploadphoto", function (e) {
    	// $('#loading_progress').html('<img src="images/loader.gif"> Uploading your photo...');

    	$('#loading_progress').html('Uploading your photo...');


    debugger;


    });



// // set info for cropping image using hidden fields
// function setInfo(i, e) {
// 	$('#x').val(e.x1);
// 	$('#y').val(e.y1);
// 	$('#w').val(e.width);
// 	$('#h').val(e.height);
// }

// 	var p = $("#uploadPreview");

// 	// prepare instant preview
//   // $("#Photo_fldUploadImage").change(function(){
//     $("body").on('change', "#Photo_fldUploadImage", function (e) {


//     debugger;
// 		// fadeOut or hide preview
// 		p.fadeOut();

// 		// prepare HTML5 FileReader
// 		var oFReader = new FileReader();
// 		oFReader.readAsDataURL(document.getElementById("Photo_fldUploadImage").files[0]);

// 		oFReader.onload = function (oFREvent) {
// 	   		p.attr('src', oFREvent.target.result).fadeIn();
// 		};
// 	});

// 	// implement imgAreaSelect plug in (http://odyniec.net/projects/imgareaselect/)
// 	$('img#uploadPreview').imgAreaSelect({
// 		// set crop ratio (optional)
// 		aspectRatio: '1:1',
// 		onSelectEnd: setInfo
// 	});


EOD;

Yii::app()->clientScript->registerScript('image_upload_and_crop', $script, CClientScript::POS_READY);

?>