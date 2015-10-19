<div class="container topheader">
   <div class="row">
      <div class="span8">
         <h1><?php echo __('Search Results'); ?></h1>
         <form id="kb-search" method="get" action="index.php">
            <input type="hidden" value="search" name="a">
            <div class="row">
               <div class="form-group">
                  <div class="col-md-3">
                     <input type="text" value="" name="q" size="20" id="query" class="form-control">
                  </div>
                  <!--<div class="col-md-3">
                     <select id="cid" name="cid" class="form-control">
                         <option value="">&mdash; All Categories &mdash;</option>
                         <option value="1">Sample Category 1 (3)</option>                </select>
                     </div>-->
                  <div class="col-md-3">
                     <select class="form-control" name="topicId" id="topic-id">
                        <option value="">&mdash; <?php echo __('All Help Topics');?> &mdash;</option>
                        <?php
                           $sql='SELECT ht.topic_id, CONCAT_WS(" / ", pht.topic, ht.topic) as helptopic, count(faq.topic_id) as faqs '
                               .' FROM '.TOPIC_TABLE.' ht '
                               .' LEFT JOIN '.TOPIC_TABLE.' pht ON (pht.topic_id=ht.topic_pid) '
                               .' LEFT JOIN '.FAQ_TOPIC_TABLE.' faq ON(faq.topic_id=ht.topic_id) '
                               .' WHERE ht.ispublic=1 '
                               .' GROUP BY ht.topic_id '
                               .' HAVING faqs>0 '
                               .' ORDER BY helptopic ';
                           if(($res=db_query($sql)) && db_num_rows($res)) {
                               while($row=db_fetch_array($res))
                                   echo sprintf('<option value="%d" %s>%s (%d)</option>',
                                           $row['topic_id'],
                                           ($_REQUEST['topicId'] && $row['topic_id']==$_REQUEST['topicId']?'selected="selected"':''),
                                           $row['helptopic'], $row['faqs']);
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-md-3">
                     <input class="btn btn-block btn-info" type="submit" value="Search" id="searchSubmit" class="button">
                  </div>
               </div>
            </div>
         </form>
         <div class="panel panel-default faqlist">
            <div class="panel-heading">
               <h2 class="panel-title">  <?php if ($faqs->exists(true)) { echo '<div id="faq">'.sprintf(__('(%d) FAQs matched your search criteria.'),
                  $faqs->count()); } else { echo '<strong class="faded">'.__('The search did not match any FAQs.').'</strong>'; }?></h2>
            </div>
            <div class="panel-body">
               <?php
                  if ($faqs->exists(true)) {
                          echo '<div id="faq">
                          <ol>';
                      foreach ($faqs as $F) {
                          echo sprintf(
                              '<li><a href="faq.php?id=%d" class="previewfaq">%s</a></li>',
                              $F->getId(), $F->getLocalQuestion(), $F->getVisibilityDescription());
                      }
                      echo '</ol></div></div>';
                  }
                  ?>
                 <div class="panel-footer">
               <a href="index.php" class="back">« Go Back</a>
            </div>
            </div>
         </div>
      </div>
   </div>
</div>