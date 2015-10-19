<?php
   $title=($cfg && is_object($cfg) && $cfg->getTitle())
       ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
   $signin_url = ROOT_PATH . "login.php"
       . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
   $signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();
   
   header("Content-Type: text/html; charset=UTF-8");
   ?>
<!DOCTYPE html>
<html
<?php
   if (($lang = Internationalization::getCurrentLanguage())
           && ($info = Internationalization::getLanguageInfo($lang))
           && (@$info['direction'] == 'rtl'))
       echo ' dir="rtl" class="rtl"';
   if ($lang) {
       $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
       $langs = Internationalization::rfc1766($langs);
       echo ' lang="' . $lang . '"';
       header("Content-Language: ".implode(', ', $langs));
   }
   ?>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <title><?php echo Format::htmlchars($title); ?></title>
   <meta name="description" content="customer support platform">
   <meta name="keywords" content="osTicket, Customer support system, support ticket system">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?231f11e" media="screen"/>
   <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/pps/css/theme.css?231f11e" media="screen"/>
   <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?231f11e" media="print"/>
   <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?231f11e" media="screen" />
   <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?231f11e" rel="stylesheet" media="screen" />
   <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?231f11e" media="screen"/>
   <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?231f11e" media="screen"/>
   <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?231f11e"/>
   <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?231f11e"/>
   <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?231f11e"/>
   <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/pps/css/bootstrap.min.css?231f11e" media="screen"/>
   <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?231f11e"/>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.11.2.min.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js?231f11e"></script>
   <script src="<?php echo ROOT_PATH; ?>js/osticket.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/pps/js/bootstrap.min.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/pps/js/pps-jquery.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?231f11e"></script>
   <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?231f11e"></script>
   <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/fabric.min.js?231f11e"></script>
   <?php
      if($ost && ($headers=$ost->getExtraHeaders())) {
          echo "\n\t".implode("\n\t", $headers)."\n";
      }
      
      // Offer alternate links for search engines
      // @see https://support.google.com/webmasters/answer/189077?hl=en
      if (($all_langs = Internationalization::getConfiguredSystemLanguages())
          && (count($all_langs) > 1)
      ) {
          $langs = Internationalization::rfc1766(array_keys($all_langs));
          $qs = array();
          parse_str($_SERVER['QUERY_STRING'], $qs);
          foreach ($langs as $L) {
              $qs['lang'] = $L; ?>
   <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
      echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
   <?php
      } ?>
   <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
   hreflang="x-default";
   <?php
      }
      ?>
</head>
<body>
   <div id="container" class="ppsbootstrap">
   <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container-fluid">
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#pps-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>index.php" title="<?php echo __('Support Center'); ?>"><?php echo $title; ?></a>
         </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="pps-navbar-collapse-1">
            <ul class="nav navbar-nav">

               <?php
                  if (($all_langs = Internationalization::getConfiguredSystemLanguages()) && (count($all_langs) > 1)) {
                      $qs = array();
                      parse_str($_SERVER['QUERY_STRING'], $qs);?>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-flag"></i><span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu"><?php
                      foreach ($all_langs as $code=>$info) {
                          list($lang, $locale) = explode('_', $code);
                          $qs['lang'] = $code;
                  ?>
               <li><a class="flag flag-<?php echo strtolower($locale ?: $info['flag'] ?: $lang); ?>"
                  href="?<?php echo http_build_query($qs);
                     ?>" title="<?php echo Internationalization::getLanguageDescription($code); ?>"></a>
               </li>
               <?php } ?>
                </li>
            </ul>
               <?php } //{"home":{"desc":"Support Center Home","href":"index.php","title":""},"kb":{"desc":"Knowledgebase","href":"kb\/index.php","title":""},"new":{"desc":"Open a New Ticket","href":"open.php","title":""},"status":{"desc":"Check Ticket Status","href":"view.php","title":"","active":true}} ?>
            </ul>
            <?php
                if($nav){ ?>
                        <ul class="nav navbar-nav">
                            <?php
                            //home kb new tickets status
                            if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
                                foreach($navs as $name =>$nav) {
                                    if (strpos($name, 'tickets') !== 0) { // Never show ticket menu
                                    if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== 0 && strpos($name, 'new') !== 0 && strpos($name, 'status') !== 0 && strpos($name, 'home') !== 0) {
                                    //if (strpos($_SERVER['SCRIPT_NAME'], 'view.php') !== 0 &&  strpos($name, 'new') !== 0 || strpos($name, 'status') !== 0) {
                                    echo sprintf('<li><a class="%s %s" href="%s">%s</a></li>%s',$nav['active']?'active':'',$name,(ROOT_PATH.$nav['href']),$nav['desc'],"\n");
                                    //}
                                    }
                                    }
                                }
                            } ?>
                        </ul>
                        <?php
                        }else{ ?>
                         
                        <?php
                        } ?>
            <ul class="nav navbar-nav navbar-right">
            <?php
                           if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) {
                            echo '<li><a href="#"><strong>' . Format::htmlchars($thisclient->getName()).'</strong></a></li>';
                            ?>
            <li><a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a></li>
            <li><a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a></li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><span class="caret"></span></a>
               <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a></li>
                  <?php
                     } elseif($nav) {
                         if ($cfg->getClientRegistrationMode() == 'public') { ?>
                  <?php echo __('<li><a href="#"><strong>Guest User</strong></a></li>'); 
                     }?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php
                           if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                        <li><a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a></li>
                        <?php
                           }
                           elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
                        <li><a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a></li>
                        <?php
                           }
                           } ?>                      
                     </ul>
                  </li>
               </ul>
               </ul>
         </div>
         <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
   </nav>
   <!-- End /nav -->
   <p>
   <?php
      if ($thisclient && is_object($thisclient) && $thisclient->isValid()
          && !$thisclient->isGuest()) {
       echo Format::htmlchars($thisclient->getName()).'&nbsp;|';
       ?>
   <a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a> |
   <a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a> -
   <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
   <?php
      } elseif($nav) {
          if ($cfg->getClientRegistrationMode() == 'public') { ?>
   <?php echo __('Guest User'); ?> | <?php
      }
      if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
   <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a><?php
      }
      elseif ($cfg->getClientRegistrationMode() != 'disabled') { ?>
   <a href="<?php echo $signin_url; ?>"><?php echo __('Sign In'); ?></a>
   <?php
      }
      } ?>
   </p>
   <div id="content">
   <div class="col-md-12">
   <?php if($errors['err']) { ?>
   <div id="msg_error" class="alert alert-danger"><?php echo $errors['err']; ?></div>
   <?php }elseif($msg) { ?>
   <div id="msg_notice" class="alert alert-info"><?php echo $msg; ?></div>
   <?php }elseif($warn) { ?>
   <div id="msg_warning" class="alert alert-warning"><?php echo $warn; ?></div>
   <?php } ?>
   </div>
