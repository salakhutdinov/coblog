<?php

namespace Coblog\Model;

class Post
{
    private $id;

    private $title;

    private $text;

    private $userId;

    private $author;

    private $createdAt;

    public function __construct(User $author, $title, $text)
    {
        $this->userId = $author->getId();
        $this->author = $author->getUsername();
        $this->title = $title;
        $this->text = $text;
        $this->createdAt = new \DateTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAuthor()
    {
        return $this->userName;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
