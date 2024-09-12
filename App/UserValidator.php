<?php

declare(strict_types=1);

namespace App;

class UserValidator
{
    public function validateEmail(string $email): bool
    {
        $email = $this->sanitizeInput($email);

        $pattern = "/^[a-z\d]+[\w.-]*@(?:[a-z\d]+(?:-[a-z\d]+)*\.){1,5}[a-z]{2,6}$/i";

        return preg_match($pattern, $email) === 1;
    }

    public function validatePassword(string $password): bool
    {
        $password = $this->sanitizeInput($password);
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])(?!.*\s).{8,}$/';
        return preg_match($pattern, $password) === 1;
    }

    private function sanitizeInput(string $input): string
    {
        return filter_var(trim($input), FILTER_SANITIZE_SPECIAL_CHARS);
    }
}