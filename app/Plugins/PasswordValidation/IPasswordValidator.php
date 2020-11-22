<?php


namespace App\Plugins\PasswordValidation;


interface IPasswordValidator
{
    public function validate($password): bool;
}
