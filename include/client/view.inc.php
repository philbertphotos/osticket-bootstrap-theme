<div class="container ticketheader"> <div class="row"> 
<div class="col-md-12 inwrap">
<?php
if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');

$info=($_POST && $errors)?Format::htmlchars($_POST):array();

$dept = $ticket->getDept();

if ($ticket->isClosed() && !$ticket->isReopenable())
    $warn = __('This ticket is marked as closed and cannot be reopened.');

//Making sure we don't leak out internal dept names
if(!$dept || !$dept->isPublic())
    $dept = $cfg->getDefaultDept();

if ($thisclient && $thisclient->isGuest()
    && $cfg->isClientRegistrationEnabled()) { ?>
<div class="col-md-12">
<div id="msg_info">
    <i class="icon-compass icon-2x pull-left"></i>
    <strong><?php echo __('Looking for your other tickets?'); ?></strong></br>
    <a href="<?php echo ROOT_PATH; ?>login.php?e=<?php
        echo urlencode($thisclient->getEmail());
    ?>" style="text-decoration:underline"><?php echo __('Sign In'); ?></a>
    <?php echo sprintf(__('or %s register for an account %s for the best experience on our help desk.'),
        '<a href="account.php?do=create" style="text-decoration:underline">','</a>'); ?>
    </div>
    </div>

<?php } ?>

<div class="panel panel-primary">
    <div class="panel-heading">
    <div>
        <div>
            <h3 class="panel-title">
                <?php echo sprintf(__('Ticket #%s'), $ticket->getNumber()); ?> &nbsp;

                <a href="tickets.php?id=<?php echo $ticket->getId(); ?>" title="Reload"><span class="Icon refresh"><i class="icon-refresh"></i></span></a>

<?php 
        // Only ticket owners can edit the ticket details (and other forms)?>
                <a class="action-button pull-right" href="tickets.php?a=edit&id=<?php
                     echo $ticket->getId(); ?>"> <i class="icon-edit"></i> Edit</a>

            </h3>
        </div>
    </div>
    </div>
    <div class="panel-body">
 
 <table width="100%" cellpadding="1" cellspacing="0" border="0" id="ticketInfo">   
    <tr>
        <td width="50%">
            <table class="infoTable" cellspacing="1" cellpadding="3" width="100%" border="0">
                <tr>
                    <th width="150"><?php echo __('Ticket Status');?>:</th>
                    <td><?php echo $ticket->getStatus(); ?></td>
                </tr>
                <tr>
                    <th><?php echo __('Department');?>:</th>
                    <td><?php echo Format::htmlchars($dept instanceof Dept ? $dept->getName() : ''); ?></td>
                </tr>
                <tr>
                    <th><?php echo __('Create Date');?>:</th>
                    <td><?php echo Format::datetime($ticket->getCreateDate()); ?>
                </tr>
           </table>
       </td>
       <td width="50%">
           <table class="infoTable" cellspacing="1" cellpadding="3" width="100%" border="0">
               <tr>
                   <th width="150"><?php echo __('Name');?>:</th>
                   <td><?php echo mb_convert_case(Format::htmlchars($ticket->getName()), MB_CASE_TITLE); ?></td>
               </tr>
               <tr>
                   <th width="150"><?php echo __('Email');?>:</th>
                   <td><?php echo Format::htmlchars($ticket->getEmail()); ?></td>
               </tr>
               <tr>
                   <th><?php echo __('Phone');?>:</th>
                   <td><?php echo $ticket->getPhoneNumber(); ?></td>
               </tr>
            </table>
       </td>
    </tr>
    <tr>
<!-- Custom Data -->
<?php
foreach (DynamicFormEntry::forTicket($ticket->getId()) as $idx=>$form) {
    $answers = $form->getAnswers();
    if ($idx > 0 and $idx % 2 == 0) { ?>
        </tr><tr>
    <?php } ?>
    <td width="50%">
        <table class="infoTable" cellspacing="1" cellpadding="3" width="100%" border="0">
        <?php
		foreach ($answers as $answer) {
        if (in_array($answer->getField()->get('name'), array('name', 'email', 'subject')))
            continue;
        elseif ($answer->getField()->get('private'))
            continue;
        ?>
        <tr>
        <th width="150"><?php echo $answer->getField()->get('label');
            ?>:</th>
        <td><?php echo $answer->display(); ?></td>
        </tr>
    <?php } ?>
    </table></td>
<?php } ?>
</tr>
</table>
</div>
</div>
<div class="subject"><?php echo __('Subject'); ?>: <strong><?php echo Format::htmlchars($ticket->getSubject()); ?></strong></div>
  <div class="thread-comments">
    <div class="row">
<div class="media">

<?php
    $ticket->getThread()->render(array('M', 'R'), array(
                'mode' => Thread::MODE_CLIENT,
                'html-id' => '',
				'html-class' => 'myclass')
            );
?>
</div>
</div>
</div>
<div class="clear" style="padding-bottom:10px;"></div>
<?php if($errors['err']) { ?>
    <div id="msg_error" class="alert alert-danger"><?php echo $errors['err']; ?></div>
<?php }elseif($msg) { ?>
    <div id="msg_notice" class="alert alert-info"><?php echo $msg; ?></div>
<?php }elseif($warn) { ?>
    <div id="msg_warning" class="alert alert-warning"><?php echo $warn; ?></div>
<?php } ?>

<?php

if (!$ticket->isClosed() || $ticket->isReopenable()) { ?>

<form id="reply" action="tickets.php?id=<?php echo $ticket->getId(); ?>#reply" name="reply" method="post" enctype="multipart/form-data">

    <?php csrf_token(); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Post a Reply');?></h3>
        </div>
        <div class="panel-body">
        <input type="hidden" name="id" value="<?php echo $ticket->getId(); ?>">
        <input type="hidden" name="a" value="reply">
        <table border="0" cellspacing="0" cellpadding="3" style="width:100%">
            <tr>
                <td colspan="2">
                    <?php
                    if($ticket->isClosed()) {
                        $msg='<b>'.__('Ticket will be reopened on message post').'</b>';
                    } else {
                        $msg=__('To best assist you, we request that you be specific and detailed');
                    }
                    ?>
                    <span id="msg"><em><?php echo $msg; ?> </em></span><font class="error">*&nbsp;<?php echo $errors['message']; ?></font>
                    <br/>
                    <div class="form-group">
                    <textarea  name="message" id="message" cols="50" rows="9" wrap="soft"
                        data-draft-namespace="ticket.client"
                        data-draft-object-id="<?php echo $ticket->getId(); ?>"
                        class="richtext ifhtml draft"><?php echo $info['message']; ?></textarea>
                    </div>
            <?php
            if ($messageField->isAttachmentsEnabled()) { ?>
    <?php
                print $attachments->render(true);
    ?>
            <?php
            } ?>
                </td>
            </tr>
        </table>
        </div>
     </div>
    <p>
        <input class="btn btn-primary" type="submit" value="<?php echo __('Post Reply');?>">
        <input class="btn btn-warning" type="reset" value="<?php echo __('Reset');?>">
        <input class="btn btn-danger" type="button" value="<?php echo __('Cancel');?>" onClick="history.go(-1)">
    </p>
</form>
<?php
} ?>
</div>
</div></div>