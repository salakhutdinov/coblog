<?php

require '_header.html.php';
?>
<h1>Posts</h1>
<?php if ($app['auth_manager']->isLoggedIn()) : ?>
    <p><a href="/new">Add post</a></p>
<?php endif; ?>
<?php foreach ($posts as $post) : ?>
    <div>
        <h2><?=$post->getTitle()?></h2>
        <p><?=nl2br($post->getText())?></p>
        <p>Posted at: <?=$post->getCreatedAt()->format('d.m.Y H:i')?></p>
    </div>
<?php endforeach; ?>
<?php

require '_footer.html.php';