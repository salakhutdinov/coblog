<?php

namespace Coblog\Security;

class PasswordEncoder
{
    public function encodePassword($plainPassword)
    {
        return $plainPassword;
    }

    public function isPasswordValid($encodedPassword, $plainPassword)
    {
        return $encodedPassword === $plainPassword;
    }
}
