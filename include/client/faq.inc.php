<?php
if(!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category=$faq->getCategory();

?>
<div class="container topheader"> <div class="row"> 
<div class="col-md-12 inwrap">

	<h1><?php echo __('Frequently Asked Questions');?></h1>

	<div id="breadcrumbs">
	    <a href="index.php"><?php echo __('All Categories');?></a>
	    &raquo; <a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></a>
	</div>

	<div class="panel panel-default single-faq">
		<div class="panel-body">
			<div class="faq-entry">
			<h3>  <?php echo $faq->getQuestion() ?>  </h3>
			
			<div class="pull-right flush-right" style="padding-top:5px;padding-right:5px;"></div>
			<div class="clear"></div>

			<p> <?php echo Format::safe_html($faq->getAnswerWithImages()); ?></p>

			<p>
			<?php
			if($faq->getNumAttachments()) { ?>
			 <div><span class="faded"><b><?php echo __('Attachments');?>:</b></span> <i class="icon-paper-clip"></i>  <?php echo $faq->getAttachmentsLinks(); ?> </div>
			<?php
			} ?>
			</p>
			</div>
		</div>

		<div class="panel-footer">
        <?php //echo 'TEST:' . $faq->getHelpTopics()->count() ?>
			<div class="article-meta"><span class="faded"><b><?php echo __('Help Topics');?>:</b></span>
			    <?php if ($faq->getHelpTopics()->count()) { ?>
<section>
    <strong><?php echo __('Help Topics'); ?></strong>
<?php foreach ($faq->getHelpTopics() as $T) { ?>
    <div><?php echo $T->topic->getFullName(); echo json_encode($T);?></div>
    
<?php } ?>
</section>
<?php }?>
			</div>
		</div>
	</div>

	<div class="faded">&nbsp;<?php //echo __('Last updated').' '.Format::db_daydatetime($category->getUpdateDate()); ?></div>

</div>
</div></div>
