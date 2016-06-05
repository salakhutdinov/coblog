<?php

require '_header.html.php';
?>
<p><a href="/">&lt;- Back</a></p>
<h1><?=$post->getTitle()?></h1>
<p><?=nl2br($post->getText())?></p>
<p>Posted at <?=$post->getCreatedAt()->format('d.m.Y H:i')?> by <?=$post->getAuthor()?></p>
<h2>Comments</h2>
<?php foreach ($comments as $comment) : ?>
    <div>
        <p><?=nl2br($comment->getText())?></p>
        <p>Commented at <?=$comment->getCreatedAt()->format('d.m.Y H:i')?> by <?=$comment->getAuthor()?></p>
    </div>
<?php endforeach; ?>

<h2>New comment</h2>
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
    <input type="submit" value="Comment">
</form>
<?php

require '_footer.html.php';
