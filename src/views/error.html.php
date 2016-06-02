<?php

require '_header.html.php';
?>
<h1>Error <?=$exception->getCode()?></h1>
<p><?=$exception->getMessage()?></p>
<?php

require '_footer.html.php';