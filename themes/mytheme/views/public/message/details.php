<div class="message widget">
        <div>
           <table>
                <tr>
                    <td><a class='message_reply' href="<?php echo $this->createUrl('/message/reply/', array('message' => $model->id)); ?>">
                    Reply to this message</a></td>
                    <td><a class='message_delete' rel='<?php echo $model->id; ?>' href="<?php echo $this->createUrl('/message/delete/', array('message' => $model->id)); ?>">
                    Delete this message</a></td>
                </tr>
            </table>
        </div>
    <div>
    <h1>View message</h1>
        <table>
        <tr>
            <th>From</th>
            <td><?php echo $model->sender_user->last_name.','.$model->sender_user->first_name; ?></td>
        </tr>
        <tr>
            <th>Subject</th>
            <td><?php echo $model->subject; ?></td>
        </tr>
        <tr>
            <th>Sent</th>
            <td><?php echo $model->sent; ?></td>
        </tr>
        <tr>
            <th>Message</th>
            <td><div id='inbox_message'><?php echo $model->message; ?></div></td>
        </tr>
        </table>
    </div>
</div>