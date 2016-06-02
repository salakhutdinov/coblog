<?php

namespace Coblog\Model;

class User
{
    private $id;

    private $userName;

    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
