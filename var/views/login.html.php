<?php

require '_header.html.php';
?>
<h1>Login form</h1>
<?php if ($error) : ?>
<div>
    Error: <?=$error?>
</div>
<br>
<?php endif; ?>
<form action="<?=$form->getAction()?>" method="<?=strtolower($form->getMethod())?>">
<?php foreach ($form->getFields() as $name => $field) : ?>
    <label>
        <?=$name?>
        <input type="<?=$field->getType()?>" name="<?=$field->getName()?>" value="">
    </label>
    <?php if ($field->hasErrors()) : ?>
        <?php foreach ($field->getErrors() as $error) : ?>
            <span class="error"><?=$error?></span>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>
    <input type="submit" value="Log in!">
</form>
<?php

require '_footer.html.php';
