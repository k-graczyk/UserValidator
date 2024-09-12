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
        $errors = [];
        if (!preg_match('/[a-z]/', $password)) {
            array_push($errors, "Hasło musi zawierać małą literę.");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            array_push($errors, "Hasło musi zawierać dużą literę.");
        }

        if (!preg_match('/\d/', $password)) {
            array_push($errors, "Hasło musi zawierać cyfrę.");
        }

        if (!preg_match('/[\W_]/', $password)) {
            array_push($errors, "Hasło musi zawierać znak specjalny");
        }

        if (preg_match('/\s/', $password)) {
            array_push($errors, "Hasło nie może zawierać spacji");
        }
        if (strlen($password) < 8) {
            array_push($errors, "Hasło musi mieć co najmniej 8 znaków.");
        }
        if (!empty($errors)) {
            $errorMessage = implode("\n", $errors);
            throw new \Exception($errorMessage);
        }

        return true;
    }


    private function sanitizeInput(string $input): string
    {
        return filter_var(trim($input), FILTER_SANITIZE_SPECIAL_CHARS);
    }
}