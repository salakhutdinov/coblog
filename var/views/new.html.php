<?php

require '_header.html.php';
?>
<h1>New post</h1>
<form action="<?=$form->getAction()?>" method="<?=strtolower($form->getMethod())?>">
<?php foreach ($form->getFields() as $name => $field) : ?>
    <label>
        <?=$name?>
        <?php if ($field->getType() == 'textarea') : ?>
        <textarea name="<?=$field->getName()?>"><?=$field->getValue()?></textarea>
        <?php else : ?>
        <input type="<?=$field->getType()?>" name="<?=$field->getName()?>" value="<?=$field->getValue()?>">
        <?php endif; ?>
        
    </label>
    <?php if ($field->hasErrors()) : ?>
        <?php foreach ($field->getErrors() as $error) : ?>
            <span class="error"><?=$error?></span>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>
    <input type="submit" value="Post">
</form>
<?php

require '_footer.html.php';
