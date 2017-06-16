<?php
$BUTTONS = isset($BUTTONS) ? $BUTTONS : true;
?>
 <div class="container ticket-bar"><div class="row"> 
	<?php //echo $config->get ( 'theme-pop' ); ?>
<?php if ($BUTTONS) { ?>
<?php
    if ($cfg->getClientRegistrationMode() != 'disabled'
        || !$cfg->isClientLoginRequired()) { ?>
<div class="col-md-6">
    <div id="new_ticket" class="ticket_action">
        <div class="action-cover">
<h3>Open a New Ticket</h3>
			<div>Please provide as much detail as possible so we can best assist you. To update a previously submitted ticket, please login.</div>
            <div class="front-page-button">
                <a href="open.php" class="blue button">
                    <?php echo __( 'Open a New Ticket');?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="col-md-6">
    <div id="check_status" class="ticket_action">
        <div class="action-cover">
		 <h3>Check Ticket Status</h3>
                <div>We provide archives and history of all your current and past support requests complete with responses.</div>
            <div class="front-page-button">
                <a href="view.php" class="green button">
                    <?php echo __( 'Check Ticket Status');?>
                </a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php } ?>
        <div class="content"><?php
    $resources = Page::getActivePages()->filter(array('type'=>'other'));
    if ($resources->all()) { ?>
            <section><div class="header"><?php echo __('Other Resources'); ?></div>
<?php   foreach ($resources as $page) { ?>
            <div><a href="<?php echo ROOT_PATH; ?>pages/<?php echo $page->getNameAsSlug();
            ?>"><?php echo $page->getLocalName(); ?></a></div>
<?php   } ?>
            </section>
<?php
    }
        ?></div>
    </div>
