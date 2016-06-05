<?php

$config = require __DIR__ . '/config/config.php';

$client = new \MongoClient($config['db_server']);
$db = $client->$config['db_name'];
$userCollection = $db->User;
$postCollection = $db->Post;

$userCollection->drop();
$postCollection->drop();

$user = [
    '_id' => new \MongoId,
    'email' => 'test@example.com',
    'password' => 'test',
    'createAt' => new \MongoDate,
];

$userCollection->insert($user);

$post = [
    '_id' => new \MongoId,
    'author' => $user['email'],
    'userId' => (string) $user['_id'],
    'title' => 'Post title',
    'text' => 'Post content',
    'createdAt' => new \MongoDate,
];

$postCollection->insert($post);
