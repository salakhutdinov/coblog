<?php

require '_header.html.php';
?>
<h1>Posts</h1>
<?php foreach ($posts as $post) : ?>
    <div>
        <h2><?=$post->getTitle()?></h2>
        <p><?=nl2br($post->getText())?></p>
    </div>
<?php endforeach; ?>
<?php

require '_footer.html.php';