<html>
<head>
    <title><?=(isset($title)) ? $title : 'Coblog' ?></title>
</head>
<body>

<div style="text-align: right;">
    Logged in as: <?=$app['auth_manager']->isLoggedIn() ? $app['auth_manager']->getCurrentUser()->getUsername() . ' (<a href="/logout">logout</a>)' : 'Guest (<a href="/login">login</a>)'?>
</div>
