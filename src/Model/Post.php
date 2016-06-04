<?php

namespace Coblog\Model;

class Post
{
    private $id;

    private $title;

    private $text;

    private $userId;

    private $userName;

    private $createdAt;

    public function __construct(User $user = null, $title = null, $text = null)
    {
        //$this->userId = $user->getId();
        //$this->userName = $user->getName();
        $this->title = $title;
        $this->text = $text;
        $this->createdAt = new \DateTime;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
