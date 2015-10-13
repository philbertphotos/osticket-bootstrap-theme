<?php
    // Form headline and deck with a horizontal divider above and an extra
    // space below.
    // XXX: Would be nice to handle the decoration with a CSS class
	//echo "Panel:" . $form->getTitle() . "-" . $form->getid();
    ?>
 <div class="panel panel-default">
    <div class="panel-heading">
        <?php print ($form instanceof DynamicFormEntry) 
            ? $form->getForm()->getMedia() : $form->getMedia(); ?>
        <h3 class="panel-title"><?php echo Format::htmlchars($form->getTitle()); ?></h3>
        <em><?php echo Format::htmlchars($form->getInstructions()); ?></em>
    </div>
    <div class="panel-body">
    <?php
	if ($form->getTitle() == 'Ticket Details'){
		echo '<div class="form">';
	} else {
		echo '<div class="form-inline">';
	}
	
    // Form fields, each with corresponding errors follows. Fields marked
    // 'private' are not included in the output for clients
    global $thisclient;
    foreach ($form->getFields() as $field) {
        if (isset($options['mode']) && $options['mode'] == 'create') {
            if (!$field->isVisibleToUsers() && !$field->isRequiredForUsers())
                continue;
        }
        elseif (!$field->isVisibleToUsers() && !$field->isEditableToUsers()) {
            continue;
        }
        ?>
		
        <div class="form-group">
            
            <?php if (!$field->isBlockLevel()) { ?>
                <label for="<?php echo $field->getFormName(); ?>"><span class="<?php
                    if ($field->isRequiredForUsers()) echo 'required'; ?>">
                <?php echo Format::htmlchars($field->getLocal('label')); ?>
            <?php if ($field->isRequiredForUsers()) { ?>
            <font class="error">*</font>
            <?php }
            ?>
			</label>
			</span><?php
                if ($field->get('hint')) { ?>
                    <em style="color:gray;display:inline-block"><?php
                        echo Format::viewableImages($field->getLocal('hint')); ?></em>
                <?php
                } ?>
            <?php
            }
            $field->render(array('client'=>true));
            ?></label><?php
            foreach ($field->errors() as $e) { ?>
                <div class="error"><?php echo $e; ?></div>
            <?php }
            $field->renderExtras(array('client'=>true));
            ?>
            
        </div>
        <?php
    }
?>
        </div>
    </div>
</div>