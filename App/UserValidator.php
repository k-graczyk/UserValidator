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

        $checks = [
            $this->containSmallLetter($password),
            $this->containCapitalLetter($password),
            $this->containInt($password),
            $this->containSpecialChar($password),
            $this->notContainSpaces($password),
            $this->checkLenght($password)
        ];

        return in_array(false, $checks) ? false : true;
    }

    private function containSmallLetter(string $password): bool
    {
        return preg_match('/[a-z]/', $password) ? true : false;
    }
    private function containCapitalLetter($password): bool
    {
        return preg_match('/[A-Z]/', $password) ? true : false;
    }

    private function containInt($password): bool
    {
        return preg_match('/\d/', $password) ? true : false;
    }
    private function containSpecialChar($password): bool
    {
        return preg_match('/[\W_]/', $password) ? true : false;
    }
    private function notContainSpaces($password): bool
    {
        return !preg_match('/\s/', $password) ? true : false;
    }

    private function checkLenght($password): bool
    {
        return strlen($password) >= 8 ? true : false;
    }

    private function sanitizeInput(string $input): string
    {
        return filter_var(trim($input), FILTER_SANITIZE_SPECIAL_CHARS);
    }
}