
<style>
#main {
	background-color: white;
	/* top: 66px; */
	margin-top: -36px;
	position: relative;

	/*   text-align: left; */
	/*   bottom: 3px; */
	/* /*   left: 0px; */
	*/
	/* /*   width: 23.4043%; */
	*/
	/*   padding-top: 10px; */
	/*   padding-right: 10px; */
	/*   padding-bottom: 10px; */
	/*   padding-left: 10px; */
	/*   box-shadow: #b0b0b0; */
	/*   z-index: 20; */
}

</style>

 <style>
      ul {
          padding:0 0 0 0;
          margin:0 0 0 0;
      }
      ul li {
          list-style:none;
          margin-bottom:25px;
      }
      ul li img {
          cursor: pointer;
      }
/*       .modal-body { */
/*           padding:5px !important; */
/*       } */
/*       .modal-content { */
/*           border-radius:0; */
/*       } */
/*       .modal-dialog img { */
/*           text-align:center; */
/*           margin:0 auto; */
/*       } */
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
/*       .modal-dialog { */
/*           max-width:500px; */
/*           padding-top: 90px; */
/*       } */
/*       @media screen and (min-width: 768px){ */
/*           .modal-dialog { */
/*               width:500px; */
/*               padding-top: 90px; */
/*           } */
/*       } */
      @media screen and (max-width:1500px){
          #ads {
              display:none;
          }
      }
  </style>

 <?php
 $script = <<<EOD

 debugger;
     // // $('input.rating').rating();

            $('li img').on('click',function(){

   //  debugger;
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

        // debugger;

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


    $('body').on('change', '.rating', function() {

        var url = '/webuser/profile/reviewbusiness/';

		// process the form. Note that there is no data send as posts arguements.
		$.ajax({
			type 		: 'POST',
			url 		: url,
		    data 		: {
                             business_id:$(this).attr('rel'),
                             rating:$(this).val()
                          },
			dataType 	: 'json'
		})
		// using the done promise callback
		.done(function(data) {

            var results = JSON.parse(data);

            if (results.result == false)
            {
                alert(results.message);
            }

		});

    });



    // Business Review popover settings
    var popOverSettings = {
        placement: 'right',
        container: 'body',
        html: true,
        selector: '[rel="review_popover"]',
        callback: function() {
            $('input.review_rating').rating();
        },
        content: function () {
            var refid = $(this).attr('refid');
            $('#review_business_id').val(refid);
            return $('#review-box').html();
        }
    }

    var tmp = $.fn.popover.Constructor.prototype.show;
    $.fn.popover.Constructor.prototype.show = function () {
        tmp.call(this);
        if (this.options.callback) {
            this.options.callback();
        }
    };



    $('body').popover(popOverSettings);
    // Hide
    $('body').on('click', '.close-review', function() {
          $('[rel="review_popover"]').popover('hide');
    });


    $('body').on('submit', '#review_form', function(event) {

        event.preventDefault();

        var form_values = $(this).serialize();
        var url = '/webuser/profile/reviewbusiness/';

        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(),
               success: function(data)
               {
                   alert(data);
               }
        });

        $('[rel="review_popover"]').popover('hide');
        return false; // avoid to execute the actual submit of the form.
    });


EOD;

Yii::app()->clientScript->registerScript('register_script_name', $script, CClientScript::POS_READY);

?>

    <!-- Thumnbail modal popup -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Thumbnai modal popup -->

<!-- Review form popup -->
            <div class="row" id="review-box" style="display:none;">
                <div class="col-md-12">
                    <form accept-charset="UTF-8" action="" method="post" id='review_form'>
                        <input type='hidden' id="review_business_id" name="review_business_id">
                        <textarea class="form-control animated" cols="50" id="review_text" name="review_text" placeholder="Enter your review here..." rows="5"></textarea>

                        <span><input type="number" name="review_rating" id="review_rating"  class="review_rating" value='' /></span>

                        <div class="text-right">
                            <button class="close-review btn btn-error btn-lg" type="reset">Cancel</button>
                            <button class="btn btn-success btn-lg" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
<!-- /.Review form popup -->



<form action="#" class="form-horizontal"  role="form" id="frmBizProfile" method="post">
   <input type="hidden" id="business_id" name="business_id"  value="<?php echo $model->attributes['business_id']; ?>" /><br/>


   <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Invite My Friends</h4>

            </div>
            <div class="modal-body">

                <div class="te">
                    <div class="row" style="height:600px;overflow:auto;">

==============================================================================
==============================================================================
==============================================================================
    <div class="container">
        <!--  start anel -->
        <div class="row">
            <br />
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-warning">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo CHtml::link(CHtml::encode($model->attributes['business_name']), $model->attributes['business_id'], array('title' => CHtml::encode($model->attributes['business_name']))); ?>
                        </h3>
                    </div>

                    <div class="panel-body">

                            <!-- Main business information panel -->
                            <div class="col-lg-8">

                                <!--  Photo -->
                                <div class="col-lg-12">
                                    <div
                                        style="border: 1px solid #066A75; padding: 3px; width: 450px; height: 450px;"
                                        id="left">
                                        <a href="#"><?php echo CHtml::image(Yii::app()->request->baseUrl .'/uploads/images/business/'.$model->attributes['image'], 'Business Image', array("width"=>"450px" ,"height"=>"450px")); ?></a>
                                    </div>
                                </div>

                                <!-- Image Gallery-->
                                <div class="col-lg-12">
                                    <div class="container">
                                    <h4>Photos :</h4><br/>

                                        <ul class="row">
<?php                                   foreach ($photos as $photo) { ?>
                                            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                                                <img class="img-responsive" src="http://placehold.it/300x200">
                                            </li>
<?php                                   } ?>
                                        </ul>
                                    </div>

                                </div>

                                <span class="business_description"><?php echo CHtml::encode($model->attributes['business_description']); ?></span>


                                <!-- Tags -->
                                <div class="col-lg-12">
                                  <h4>Tags and Categories :</h4><br/>
<?php

                                  // Business categories
                                  foreach ($model->businessCategories as $businessCategory)
                                  {
                                      $modelCategory = Category::model()->findByPk($businessCategory->category_id);
                                      if ($modelCategory != null)
                                      {
?>
                                        <span class="label label-sucess"><?php echo CHtml::Encode($modelCategory->category_name); ?></span>
<?php
                                      }

                                  }
?>
                                </div>



                                <!-- Contact Details -->
                                <div class="col-lg-12">
                                    <h4>Contact Details</h4>
                                    <p>Address:<br/>
                                       <?php echo $model->attributes['business_address1']; ?></p>
                                    <p><?php echo $model->attributes['business_address2']; ?></p>
                                    <br/>
                                    <p><?php echo $model->attributes['business_city_id']; ?></p>
                                    <br/>
                                    <p><?php echo $model->attributes['business_zipcode']; ?></p>
                                    <br/>
                                    <p>Phone : <?php echo $model->attributes['business_phone']; ?></p>
                                    <p>Ext : <?php echo $model->attributes['business_phone_ext']; ?></p>
                                    <p>Email : <?php echo $model->attributes['business_email']; ?></p>
                                    <p>Website : <?php echo $model->attributes['business_website']; ?></p>

                                </div>

                                <!-- Reviews -->
                                <hr>
                                <div class="white-box">
                                    <!-- Rating -->
                                    <div class="col-lg-12">
                                        <h4>Reviews :</h4><br/>
<?php if ((!Yii::app()->user->isGuest) && ($model->business_allow_review == 'Y')) { ?>
                                        <button class="pop-review-form" rel="review_popover" refid="<?php echo $model->business_id; ?>"  >Your Review</button>

<?php } ?>

                                        <h4>Other Reviews :</h4><br/>
<?php

                                          // Business reviews
                                          foreach ($model->businessReviews as $businessReview)
                                          {
                                              $this->renderPartial("business_reviews",array('model' => $businessReview));
                                          }
?>

                                    </div>
                                </div>
                                <!-- /.Reviews -->

                                <!-- Coupons -->
                                <hr>
                                <div class="white-box">
                                    <h5 class="sidebar-title"><b>Coupons</b>
                                    </h5>
                                    <ul class="sidebar-list">

                                        <?php $this->renderPartial("business_coupons"); ?>

                                    </ul>
                                </div>



                            </div>
                            <!-- /.Main business information panel -->

                            <!--  Right hand panel -->
                            <div class="col-lg-4">


                                <div class="col-lg-12">

                                    <div class="box">

                                        <?php $this->renderPartial('business_map'); ?>

                                    </div>
                                    <hr>

                                    <div class="advert">
                                        <?php $this->renderPartial('advertisements_temporary'); ?>

                                    </div>
                                    <hr>

                                    <div class="white-box featured">
                                        <?php $this->renderPartial('addnewbusiness_ad'); ?>
                                    </div>

                                    <hr>
                                    <div class="white-box">
                                        <?php $this->renderPartial('new_business_summary'); ?>
                                    </div>
                                    <hr>
                                    <div class="widget white-box">
                                        <?php $this->renderPartial('latest_forum_posts'); ?>
                                    </div>


                                    <hr>
                                    <div class="white-box">
                                        <?php $this->renderPartial('business_events', array('model' => $model->events)); ?>
                                    </div>
                                </div>



                            </div>
                            <!--  /.Right hand panel  -->

                    </div>
                </div>
            </div>

        </div>
        <!--  end panel -->
    </div>

==============================================================================
==============================================================================
==============================================================================


                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary wiz-prev-nav pull-left">Previous</button>
            <button type="button" class="btn btn-primary wiz-next-nav  pull-left">Next</button>
            <button type="button" class="btn btn-default wiz-close-nav " data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary wiz-finish-nav">Send invitation</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>



