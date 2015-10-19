<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired())
    $button = __("Email Access Link");
else
    $button = __("View Ticket");
?>
<div class="container topheader"><div class="row">
<div id="login-overlay">
   <div class="content">
      <div class="modal-header">
         <div class="modal-title lead"><?php echo __('Check Ticket Status'); ?></div>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-xs-6">
               <p class="lead"></span></p>
               <ul class="list-unstyled" style="line-height: 2">
                  <li><span class="fa fa-check text-success"></span><?php
echo __('Please provide your email address and a ticket number.');
if ($cfg->isClientEmailVerificationRequired())
    echo ' '.__('An access link will be emailed to you.');
else
    echo ' '.__('This will sign you in to view your ticket.');
?></li>

               </ul>
    <div class="instructions">
<?php if ($cfg && $cfg->getClientRegistrationMode() !== 'disabled') { ?>
        <?php echo __('Have an account with us?'); ?>
        <a href="login.php"><?php echo __('Sign In'); ?></a> <?php
    if ($cfg->isClientRegistrationEnabled()) { ?>
<?php echo sprintf(__('or %s register for an account %s to access all your tickets.'),
    '<a href="account.php?do=create">','</a>');
    }
}?>
    </div>
            </div>
            <div class="col-xs-6">
               <div class="well">
                  <form id="clientLogin" method="POST" action="login.php">
                     <?php csrf_token(); ?>
                     <div class="form-group">
                        <label for="email" class="control-label"><?php echo __('E-Mail Address'); ?></label>
                        <input id="email" type="text" placeholder="<?php echo __('e.g. john.doe@youremail.com'); ?>" class="form-control nowarn" name="lemail" value="<?php echo $email; ?>">
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group">
                        <label for="ticketno" class="control-label"><?php echo __('Ticket Number'); ?></label>
                        <input id="ticketno" type="text" placeholder="<?php echo __('e.g. 051243'); ?>" class="form-control nowarn" name="lticket" value="<?php echo $ticketid; ?>">
                        <span class=""></span>
                     </div>
                     <div id="loginErrorMsg" class="alert alert-error hide">Wrong username or password</div>
                     <button type="submit" class="btn btn-primary" value="<?php echo $button; ?>"><?php echo $button; ?></button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<p>
<?php
if ($cfg->getClientRegistrationMode() != 'disabled'
    || !$cfg->isClientLoginRequired()) {
    echo sprintf(
    __("If this is your first time contacting us or you've lost the ticket number, please %s open a new ticket %s"),
        '<a href="open.php">','</a>');
} ?>
</p>
</div></div>