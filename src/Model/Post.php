<?php

namespace Coblog\Model;

class Post
{
    private $id;

    private $text;

    private $userId;

    private $userName;

    private $createdAt;

    public function __construct(User $user, $text)
    {
        $this->userId = $user->getId();
        $this->userName = $user->getName();
        $this->text = $text;
        $this->createdAt = new \DateTime;
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
