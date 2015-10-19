<?php
$entryTypes = array('M'=>'message', 'R'=>'response', 'N'=>'note');
$user = $entry->getUser() ?: $entry->getStaff();
$name = $user ? $user->getName() : $entry->poster;
$avatar = '';
if ($user)
    $avatar = $user->getAvatar();
?>
<!--         <div class="media-heading">
          <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button> <span class="label label-info">12314</span> vertu 12 sat once yazmis
        </div>
-->

<!--<div class=" <?php echo $entryTypes[$entry->type]; ?> <?php if ($avatar) echo 'avatar'; ?>">
<?php if ($avatar) { ?>
    <span class="<?php echo ($entry->type == 'M') ? 'pull-left' : 'pull-right'; ?> avatar">
<?php echo $avatar; ?>
    </span>-->
<?php } ?>

    <div class="media-heading">
          <button class="btn btn-default btn-xs" type="button" data-toggle="collapse" data-target="#thread-id-<?php echo $entry->getId(); ?>" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button> <span class="label label-info"><?php if ($entry->flags & ThreadEntry::FLAG_EDITED) { ?>
                <span class="label label-bare" title="<?php
        echo sprintf(__('Edited on %s by %s'), Format::datetime($entry->updated), 'You');
                ?>"><?php echo __('Edited'); ?></span>
        <?php } ?></span>
<?php
            echo sprintf(__('<b>%s</b> posted %s'), $name,
                sprintf('<time class="relative" datetime="%s" title="%s">%s</time>',
                    date(DateTime::W3C, Misc::db2gmtime($entry->created)),
                    Format::daydatetime($entry->created),
                    Format::relativeTime(Misc::db2gmtime($entry->created))
                )
            ); ?>
            <span style="max-width:500px" class="faded title truncate"><?php
                echo $entry->title; ?></span>
            </span>
    </div>
<div class="panel-collapse collapse in" id="thread-id-<?php echo $entry->getId(); ?>">
          <div class="media-left">
            <div class="vote-wrap">
              <div class="save-post">
                <a href="#"><span class="glyphicon glyphicon-star" aria-label="Save"></span></a>
              </div>
            </div>
            <!-- vote-wrap -->
          </div>
          <!-- media-left -->
    <div class="media-body">
        <div><?php echo $entry->getBody()->toHtml(); ?></div>
        <div class="clear"></div>
<?php
    if ($entry->has_attachments) { ?>
    <div class="attachments"><?php
        foreach ($entry->attachments as $A) {
            if ($A->inline)
                continue;
            $size = '';
            if ($A->file->size)
                $size = sprintf('<small class="filesize faded">%s</small>', Format::file_size($A->file->size));
?>
        <span class="attachment-info">
        <i class="icon-paperclip icon-flip-horizontal"></i>
        <a class="no-pjax truncate filename" href="<?php echo $A->file->getDownloadUrl();
            ?>" download="<?php echo Format::htmlchars($A->getFilename()); ?>"
            target="_blank"><?php echo Format::htmlchars($A->getFilename());
        ?></a><?php echo $size;?>
        </span>
<?php   }  ?>
    </div>
<?php } ?>
    </div>
	          <div class="comment-meta">
              <!--<span><a href="#">delete</a></span>
              <span><a href="#">report</a></span>-->
              <span><a href="#">hide</a></span>
            </div>
	</div>

<?php
    if ($urls = $entry->getAttachmentUrls()) { ?>
        <script type="text/javascript">
            $('#thread-id-<?php echo $entry->getId(); ?>')
                .data('urls', <?php
                    echo JsonDataEncoder::encode($urls); ?>)
                .data('id', <?php echo $entry->getId(); ?>);
        </script>
<?php
    } ?>
<!--</div>-->
