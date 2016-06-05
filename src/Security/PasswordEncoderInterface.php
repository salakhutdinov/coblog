<?php

namespace Coblog\Security;

interface PasswordEncoderInterface
{
    public function encodePassword($plainPassword);

    public function isPasswordValid($encodedPassword, $plainPassword);
}
