<style type="text/css">
    #business {
        background: #ffffff;
    }
    #claim-code {
        font-size: 24px;
    }

    #claim-error {
        font-size: 18px;

    }


</style>

<div id="business">
    <div class="container">
        <h1>
            Claim Business : <?php echo CHtml::encode($business->business_name); ?>
        </h1>
       <?php if ($business->business_phone) { ?>
        <div id="claim-request">
            <div>
                <p>If this business belongs to you, you can claim the business.</p>

                <p>In order to proceed to claim your business, select the button below that says
                   <strong>'Claim your Business Now'</strong>. You will require a valid telephone service
                   that is listed against your business.</p>

                <p>Our records indicate that this business is associated to the phone number
                   <h3><?php echo CHtml::encode($business->business_phone)?></h3></p>

                <p>If this number is not correct:
                   <a class="btn btn-md btn-info" href="<?php echo Yii::app()->createUrl('/business/business/showdetails', array('business_id' => $business->business_id  )); ?>">
                        <i class="glyphicon glyphicon glyphicon-earphone"></i>
                        Submit new business number
                   </a>

                   <p>&nbsp;</p>

                   <p>To proceed, press the button below to start the Claim Process.</p>

                   <a id='claim-button' class="btn btn-md btn-success" href="<?php echo Yii::app()->createUrl('/business/business/showdetails', array('business_id' => $business->business_id  )); ?>">
                        <i class="glyphicon glyphicon-thumbs-up"></i>
                        Claim your Business Now.
                   </a>
                   <p>&nbsp;</p>
                   <p>&nbsp;</p>

            </div>
        </div>

        <div id="claim-error">

        </div>
        <p>&nbsp;</p>

        <div id="claim-container" style="display: none">
            <div>You will receive a call to the phone number <?php echo CHtml::encode($business->business_phone); ?>.
                 When you do please enter the following code to claim this business:</div>
            <div id="claim-code"></div>
        </div>
       <p>&nbsp;</p>
        <div id="claim-status">

        </div>
        <p>&nbsp;</p>
       <?php } else { ?>
            We don't have a phone associated to this business
       <?php } ?>
    </div>
</div>

<br/>
<br/><br/>

<?php

$baseUrl = $this->createAbsoluteUrl('/');

$phoneNumber        = $business->business_phone;
$makeCallUrl        = $baseUrl.'/business/business/claimcall';
$statusUpdateUrl    = $baseUrl.'/business/business/twilioverificationstatus';

$script = <<<EOD

// /////////////////////////////////////////////////////////////////////////////
// twilio verificatin
// /////////////////////////////////////////////////////////////////////////////

    var twilioVerificationData = { verificationId: 0, lastStatus: ' '};

    // check if verification status has changed
    function checkStatus() {
        var data = {verificationId: twilioVerificationData.verificationId};
        $.post('$statusUpdateUrl', data, function(e)
        {
            res = $.parseJSON(e);
            if(res.success) {
                if(res.callStatus == 'no-answer') {
                    $('#claim-status').html('There was no answer');
                    $('#claim-request').show();
                    $('#claim-code').html('');
                }
                else if(res.status == 'taken') {
                    $('#claim-status').html('Business was already claimed');
                }
                else if(res.status == 'verified') {
                    $('#claim-status').html('Congratulations! you have claimed this business');
                }
                else if(res.callStatus == 'completed') {
                    $('#claim-status').html('Verification failed');
                    $('#claim-request').show();
                    $('#claim-code').html('');
                }
                else if(res.status == 'failed') {
                    $('#claim-status').html('Wrong code please try again');
                    setTimeout(checkStatus, 3000);
                }
                else if(res.status == 'waiting') {
                    $('#claim-status').html('calling...');
                    setTimeout(checkStatus, 3000);
                }
            } else {
            }
        });
    }

    // make the call
    $('#claim-button').click(function() {
        var data = {businessPhone: '$phoneNumber', businessId: '$business->business_id'};
        $('#claim-error').html('');
        $('#claim-status').html('');
        $.post('$makeCallUrl', data, function(e) {
            var res= $.parseJSON(e);
            if(res.success) {
                $('#claim-request').hide();
                $('#claim-code').html(res.code);
                $('#claim-container').show();
                twilioVerificationData.verificationId = res.verificationId;
                checkStatus();
            } else {
                $('#claim-error').html('There was an error making the call, please try again');
                $('#claim-error').attr('class', 'alert alert-danger');
                alert(res.error);
            }
        });
        return false;
    });


EOD;

Yii::app()->clientScript->registerScript('business_claim', $script, CClientScript::POS_READY);

?>