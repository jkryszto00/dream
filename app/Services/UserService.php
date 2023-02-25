<?php

namespace App\Services;

use App\Mail\NewPasswordMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(string $name, string $email, string $blankPassword): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($blankPassword)
        ]);

        event(new Registered($user));

        return $user;
    }

    public function createUserWithEmail(string $email): User
    {
        $name = $this->createNameFromEmail($email);
        $blankPassword = $this->generatePassword();

        $user = $this->createUser(
            name: $name,
            email: $email,
            blankPassword: $blankPassword
        );

        Mail::to($user)->send(new NewPasswordMail(
            blankPassword: $blankPassword
        ));

        return $user;
    }

    private function createNameFromEmail(string $email): string
    {
        return Str::before($email, '@');
    }

    private function generatePassword(): string
    {
        return Str::password();
    }
}
