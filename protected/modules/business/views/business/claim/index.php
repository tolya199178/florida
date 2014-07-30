<style type="text/css">
    #business {
        background: #ffffff;
    }
    #claim-code {
        font-size: 24px;
    }
</style>

<div id="business">
    <div class="container">
        <h1>
            Claim Business <?php echo CHtml::encode($business->business_name); ?>
        </h1>
       <?php if ($business->business_phone) { ?>
        <div id="claim-request">
            <div>
                In our records this business is associated to the phone number <?php echo CHtml::encode($business->business_phone)?>. Do you want to be called to this phone number validate your claim on this business?
            </div>
            <a href="#" class="btn btn-primary btn-md" id="claim-button">yes</a> <a href="" class="btn btn-primary btn-md">no</a>
        </div>
        <div id="claim-error">

        </div>
        <div id="claim-container" style="display: none">
            <div>You will receive a call to the phone number <?php echo CHtml::encode($business->business_phone); ?>. When you do please enter the following code to claim this business:</div>
            <div id="claim-code"></div>
        </div>
        <div id="claim-status">

        </div>
       <?php } else { ?>
            We don't have a phone associated to this business
       <?php } ?>
    </div>
</div>


<?php

$baseUrl = $this->createAbsoluteUrl('/');

$phoneNumber = $business->business_phone;
$makeCallUrl = $baseUrl.'/business/business/claimcall';
$statusUpdateUrl = $baseUrl.'/business/business/twilioverificationstatus';

$script = <<<EOD

// /////////////////////////////////////////////////////////////////////////////
// twilio verificatin
// /////////////////////////////////////////////////////////////////////////////

    var twilioVerificationData = { verificationId: 0, lastStatus: ' '};

    // check if verification status has changed
    function checkStatus() {
        var data = {verificationId: twilioVerificationData.verificationId};
        $.post('$statusUpdateUrl', data, function(e) {
            res = $.parseJSON(e);
            if(res.success) {
                if(res.callStatus == 'no-answer') {
                    $('#claim-status').html('There was no answer');
                    $('#claim-request').show();
                    $('#claim-code').html('');
                }
                else if(res.status == 'taken') {
                    $('#claim-status').html('business was already claimed');
                }
                else if(res.status == 'verified') {
                    $('#claim-status').html('Congratulations! you have claimed this business');
                }
                else if(res.callStatus == 'completed') {
                    $('#claim-status').html('verification failed');
                    $('#claim-request').show();
                    $('#claim-code').html('');
                }
                else if(res.status == 'failed') {
                    $('#claim-status').html('wrong code please try again');
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
            }
        });
        return false;
    });


EOD;

Yii::app()->clientScript->registerScript('business_claim', $script, CClientScript::POS_READY);

?>