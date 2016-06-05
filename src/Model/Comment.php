<?php

namespace Coblog\Model;

class Comment
{
    private $id;

    private $postId;

    private $text;

    private $author;

    private $createdAt;

    public function __construct(Post $post, $author, $text)
    {
        $this->postId = $post->getId();
        $this->text = $text;
        $this->author = $author;
        $this->createdAt = new \DateTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
