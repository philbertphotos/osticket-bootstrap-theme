<div class="container topheader">
   <div class="row">
      <div class="col-md-12">
         <div class="page-title">
            <h1>Frequently Asked Questions</h1>
         </div>
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
      </div>
      <div class="col-md-12">
         <div class="kb-results">
            <?php
               $categories = Category::objects()
                   ->exclude(Q::any(array(
                       'ispublic'=>Category::VISIBILITY_PRIVATE,
                       'faqs__ispublished'=>FAQ::VISIBILITY_PRIVATE,
                   )))
                   ->annotate(array('faq_count'=>SqlAggregate::COUNT('faqs')))
                   ->filter(array('faq_count__gt'=>0));
               if ($categories->exists(true)) { ?>
            <div class="well"><?php echo __('Click on the category to browse FAQs.'); ?></div>
            <ul id="kb">
               <?php
                  foreach ($categories as $C) { ?>
               <li>
                  <i></i>
                  <div style="margin-left:45px">
                     <h4><?php echo sprintf('<a href="faq.php?cid=%d">%s (%d)</a>',
                        $C->getId(), Format::htmlchars($C->getLocalName()), $C->faq_count); ?></h4>
                     <div class="faded" style="margin:10px 0">
                        <?php echo Format::safe_html($C->getLocalDescriptionWithImages()); ?>
                     </div>
                     <?php       foreach ($C->faqs
                        ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
                        ->limit(5) as $F) { ?>
                     <div class="popular-faq"><i class="icon-file-alt"></i>
                        <a href="faq.php?id=<?php echo $F->getId(); ?>">
                        <?php echo $F->getLocalQuestion() ?: $F->getQuestion(); ?>
                        </a>
                     </div>
                     <?php       } ?>
                  </div>
               </li>
               <?php   } ?>
            </ul>
            <?php
               } else {
                   echo __('NO FAQs found');
               }
               ?>
         </div>
      </div>
   </div>
</div>