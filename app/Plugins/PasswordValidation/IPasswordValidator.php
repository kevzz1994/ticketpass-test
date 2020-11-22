<?php


namespace App\Plugins\PasswordValidation;

interface IPasswordValidator
{
    /**
     * Validates if a password is strong enough
     * @param $password string the password to validate
     * @return bool returns true on successful validation, false otherwise
     */
    public function validate(string $password): bool;
}
