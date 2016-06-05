<?php

namespace Coblog\Security;

class PlainPasswordEncoder implements PasswordEncoderInterface
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
