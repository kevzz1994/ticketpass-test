<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class PasswordValidatorProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            \App\Plugins\PasswordValidation\IPasswordValidator::class,
            \App\Plugins\PasswordValidation\HaveIBeenPwned::class
        );
    }

}
