<?php
   if(!defined('OSTCLIENTINC')) die('Access Denied');
   
   $email=Format::input($_POST['luser']?:$_GET['e']);
   $passwd=Format::input($_POST['lpasswd']?:$_GET['t']);
   
   $content = Page::lookupByType('banner-client');
   
   if ($content) {
       list($title, $body) = $ost->replaceTemplateVariables(
           array($content->getName(), $content->getBody()));
   } else {
       $title = __('Sign In');
       $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
   }
   
   ?>
<div class="container topheader">
<div class="row">
<div id="login-overlay">
   <div class="content">
      <div class="modal-header">
         <div class="modal-title lead"><?php echo Format::display($title); ?></div>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-xs-6">
               <p class="lead"><span></span></p>
               <ul class="list-unstyled" style="line-height: 2">
                  <li><span class="fa fa-check text-success"></span><?php echo Format::display($body); ?></li>
                  <?php
                     $ext_bks = array();
                     foreach (UserAuthenticationBackend::allRegistered() as $bk)
                         if ($bk instanceof ExternalAuthentication)
                             $ext_bks[] = $bk;
                     
                     if (count($ext_bks)) {
                         foreach ($ext_bks as $bk) { ?>
                  <div class="external-auth"><?php $bk->renderExternalLink(); ?></div>
                  <?php
                     }
                     } if ($cfg && $cfg->isClientRegistrationEnabled()) {
                     if (count($ext_bks)) echo '<hr style="width:70%"/>'; ?>
                  <div style="margin-bottom: 5px">
                     <?php echo __('Not yet registered?'); ?> <a href="account.php?do=create"><?php echo __('Create an account'); ?></a>
                  </div>
                  <?php } ?>
                  <div>
                     <b><?php echo __("I'm an agent"); ?></b> —
                     <a href="<?php echo ROOT_PATH; ?>scp/"><?php echo __('sign in here'); ?></a>
                  </div>
               </ul>
               <p>
                  <?php
                     if ($cfg->getClientRegistrationMode() != 'disabled'
                         || !$cfg->isClientLoginRequired()) {
                         echo sprintf(__('If this is your first time contacting us or you\'ve lost the ticket number, please %s open a new ticket %s'),
                             '<a href="open.php">', '</a>');
                     } ?>
               </p>
            </div>
            <div class="col-xs-6">
               <div class="well">
                  <form id="clientLogin" method="POST" action="login.php">
                     <?php csrf_token(); ?>
                     <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input id="username" type="text" placeholder="<?php echo __('Email or Username'); ?>" class="form-control nowarn" name="luser" value="<?php echo $email; ?>">
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input id="passwd" type="password" placeholder="<?php echo __('Password'); ?>" class="form-control nowarn" name="lpasswd" value="<?php echo $passwd; ?>">
                        <span class="help-block"></span>
                     </div>
                     <div id="loginErrorMsg" class="alert alert-error hide">Wrong username or password</div>
                     <button type="submit" class="btn btn-primary">Login</button>
                     <!--<a href="/forgot/" class="btn btn-default">Help to login</a>-->
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>