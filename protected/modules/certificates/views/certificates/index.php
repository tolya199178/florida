<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl. '/resources/libraries/select2/select2.js', CClientScript::POS_END);
?>

<style>
<!--
#certificate {
    background:#fff;
}
#allocate-user-field, #allocate-email-field input {
    width: 250px;
}
</style>
<div id="certificate">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Certificates</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#cert-list" data-toggle="tab">Certifictate List</a></li>
                        <li><a href="#purchase" data-toggle="tab">Purchase Gift Certificates</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="cert-list">
                             <?php $this->renderPartial('tabs/list', array('businessList' => $businessList)); ?>
                        </div>
                        <div class="tab-pane" id="purchase">
                            <?php $this->renderPartial('tabs/cart', array('businessList' => $businessList)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="allocateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <h3>Allocate </h3>
            </div>
            <form id="allocate-form">
                <div class="container">
                    <input type="hidden" name="certificate_id" id="certificate-id-field">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="radio" name="allocate_target" value="user" id="allocate-cert-user-radio">
                            <label for="allocate-cert-user-radio">to existing user</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="radio" name="allocate_target" value="email" id="allocate-cert-email-radio">
                            <label for="allocate-cert-email-radio">to email</label>
                        </div>
                    </div>
                    <div id="allocate-user-field">
                        <input type="text" name="allocate_user">
                    </div>
                    <div id="allocate-email-field">
                        <input type="text" name="allocate_email" placeholder="email">
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                <button type="button" class="btn btn-primary" id="allocate-submit">allocate</button>
            </div>
        </div>
    </div>
</div>

<?php

$page                   = intval(Yii::app()->request->getParam('page', 1));
$business               = intval(Yii::app()->request->getParam('business', 0));
$allocated              = intval(Yii::app()->request->getParam('allocated', -1));
$certListTableUrl       = $this->createUrl('/certificates/certificates/certificatelisttable');
$allocateUrl            = $this->createUrl('/certificates/certificates/allocate');
$userAutoCompleteURL    = Yii::app()->createUrl('/user/autocompletelist');
$cartConfirmUrl         = Yii::app()->createUrl('/certificates/certificates/cartconfirm');
$saveOrderUrl = Yii::app()->createUrl('/certificates/certificates/saveorder');

$script = <<<EOD

    var page = $page;
    var business = $business;
    var allocated = $allocated;

    function refreshList(tgtPage) {
        if(tgtPage != undefined) {
            page =  tgtPage;
        }
        $('#cert-list-table').load("$certListTableUrl?page=" + page + "&business=" + business + "&allocated=" + allocated, function(){
            $('#cert-list-pagination a').click(function(e) {
                refreshList($(e.target).attr('data-page'));
                return false;
            });
//             $('.allocate-btn').click(function(e) {
//                 $('input:radio[name=allocate_target]').filter('[value=1]').prop('checked', true);
//                 refreshAllocateForm();
//                 $('#certificate-id-field').val($(e.target).attr('data-id'));
//                 $('#allocateModal').modal();
//             });
        });
    }

    function refreshAllocateForm() {
        $('#allocate-user-field input').val('');
        $('#allocate-email-field input').val('');
        if($('input:radio[name=allocate_target]:checked').val() == 1) {
            $('#allocate-user-field').show();
            $('#allocate-email-field').hide();
        } else {
            $('#allocate-user-field').hide();
            $('#allocate-email-field').show();
        }
    }

    $("#cert-business-select").change(function() {
        business = $("#cert-business-select").val();
        refreshList();
    });

    $("#cert-allocated-select").change(function() {
        allocated = $("#cert-allocated-select").val();
        refreshList();
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tgtName = $(e.target).attr('href');
        $('#cart-error-message').html('');
        if(tgtName == '#cert-list') {
            refreshList();
        }
    })

    $('input:radio[name=allocate_target]').change(function() {
        refreshAllocateForm();
    });

    $('#allocate-user-field input').select2({
        placeholder: "Search User",
        width : "100%",
        minimumInputLength: 3,
        ajax: {
            url: "$userAutoCompleteURL",
            dataType: 'json',
                data: function (term, page) {
                    return {
                        query: term
                      };
                },
                results: function (data, page) {
                    return {
                        results: data
                    };
                }
        }
	});

    $('#allocate-submit').click(function() {
        $.post('$allocateUrl', $('#allocate-form').serialize(), function(e){
            res = $.parseJSON(e);
            if(res.success == 1) {
                $('#allocateModal').modal('hide');
                refreshList();
            } else {
            }
        });
    });

    $('#cart-continue').click(function() {
        $('#cart-error-message').html('');
        $.post('$cartConfirmUrl', $('#cart-form').serialize(), function(e) {
            var res = JSON.parse(e);
            if(res.success == 0) {
                $('#cart-error-message').html(res.data);
            } else {
                $('#cart-form-container').hide();
                $('#cart-confirm-container').html(res.data);
                $('#cancel-cart').click(function() {
                    $('#cart-form-container').show();
                    $('#cart-confirm-container').html('');
                    return false;
                });
                $('#paypal-form-submit').click(function(e) {

                    $('#paypal-form-buttons').hide();
                    $.post('$saveOrderUrl', $('#paypal-form').serialize(), function(e) {

                        var res = JSON.parse(e);

                        if(res.success == 1) {
                            $('#paypal-custom-field').val(res.purchaseId);
                            $('#paypal-form').submit();
                        }

                    });

                    return false;

                });


            }
        });
        return false;
    });


    refreshList();

EOD;

Yii::app()->clientScript->registerScript('details', $script, CClientScript::POS_READY);
?>