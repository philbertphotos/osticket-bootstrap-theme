<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
<div id="landing_page">
<?php //include CLIENTINC_DIR.'templates/sidebar.tmpl.php'; ?>

<div class="container">
<div class="row">
<div class="col-md-12 topheader">
<?php
    if($cfg && ($page = $cfg->getLandingPage()))
        echo $page->getBodyWithImages();
    else
        echo  '<h1>'.__('Welcome to the Support Center').'</h1>';
    ?>
    </div>
</div>
<div>
<div class="clear"></div>

<div>
<?php include CLIENTINC_DIR.'templates/button-form.tmpl.php'; ?>
</div>
</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
