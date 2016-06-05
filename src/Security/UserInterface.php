<?php

namespace Coblog\Security;

interface UserInterface
{
    public function getUsername();

    public function getPassword();
}
