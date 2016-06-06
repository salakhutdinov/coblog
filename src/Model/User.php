<?php

namespace Coblog\Model;

class User
{
    private $id;

    private $email;

    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getPassword()
    {
        return $this->password;
    }
}
