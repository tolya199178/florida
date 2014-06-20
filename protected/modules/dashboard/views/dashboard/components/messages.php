                            <h3>Inbox</h3>
                            <h4><a id='message_create' href="<?php echo $this->createUrl('/message/create/'); ?>">
                                    New message
                                </a>
                            </h4>

                              <div class="table-responsive" style="height:300px;overflow-y:auto;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-5">Subject</th>
                                                <th class="col-sm-4">From</th>
                                                <th class="col-sm-2">Date</th>
                                                <th class="col-sm-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">

                                        <?php foreach ($myMessages as $itemMessage) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo $this->createUrl('/message/details/', array('message' => $itemMessage->id)); ?>"
                                                       class='message_item'>
                                                       <?php echo $itemMessage->subject; ?>
                                                   </a>
                                                </td>
                                                <td><?php echo $itemMessage->sender_user->last_name.', '.$itemMessage->sender_user->first_name; ?></td>
                                                <td><?php echo $itemMessage->sent; ?></td>
                                                <td></td>
                                            </tr>
                                         <?php } ?>

                                        </tbody>
                                    </table>
                                </div>

                                <hr style="border:3px double silver;">
                                <h3>Message View</h3>
                                <div id='message_details'>
                                </div>



<?php

$baseUrl = $this->createAbsoluteUrl('/');


$script = <<<EOD

        $(".message_item").on('click', function (e) {
        	var addressValue = $(this).attr("href");
        	   $("#message_details").load(addressValue);

            return false;
        });

        // message_reply
        $("body").on('click', ".message_reply", function (e) {
        	var addressValue = $(this).attr("href");
        	   $("#message_details").load(addressValue);

            return false;
        });

        // message_reply
        $("body").on('click', "#message_create", function (e) {

       debugger;

        	var addressValue = $(this).attr("href");
        	   $("#message_details").load(addressValue);

            return false;
        });

        // message_delete
        $("body").on('click', ".message_delete", function (e) {

            e.preventDefault(); // prevent default form submit

            var user_confirm = confirm("Are you sure you want to delete this message?");

            if (user_confirm == true) {
                $.ajax({
                	type: 'POST',
                	url: $(this).attr("href"),
                	data: {id: $(this).attr("rel")} ,

                	success: function(data, status) {
                 	   $("#message_details").html(data);
                	}
            	});
                return false;

            } else {
                return false;
            }

        });

        // message_reply
        $("body").on('click', "#message_reply", function (e) {

       debugger;

        	var addressValue = $(this).attr("href");
        	   $("#message_details").load(addressValue);

            return false;
        });


        // message_create_form
        $("body").on('submit', "#message_create_form, #message_reply_form", function (e) {

       debugger;

            e.preventDefault(); // prevent default form submit

            var thisform = $(this);

            $.ajax({
            	type: thisform.attr('method'),
            	url: thisform.attr('action'),
            	data: thisform.serialize(),

            	success: function(data, status) {
             	   $("#message_details").html(data);
            	}
        	});;

            return false;
        });
EOD;

Yii::app()->clientScript->registerScript('message_list', $script, CClientScript::POS_READY);

?>