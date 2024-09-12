<?php

declare(strict_types=1);

namespace App;

class UserValidator
{
    public function validateEmail(string $email): bool
    {
        $email = $this->sanitizeInput($email);

        if (!$this->containAtSign($email)) {
            return false;
        }

        $emailExplode = explode("@", $email);
        $local = $emailExplode[0];
        $fullDomain = $emailExplode[1];

        if (!$this->validLocal($local)) {
            return false;
        }

        if (!$this->containDot($fullDomain)) {
            return false;
        }

        $domainExplode = explode(".", $fullDomain);
        $domain = $domainExplode[0];
        $tld = $domainExplode[1];

        if (!$this->validDomain($domain)) {
            return false;
        }

        if (!$this->validTld($tld)) {
            return false;
        }

        return true;
    }

    private function validTld(string $tld): bool
    {
        return preg_match("/[a-z]{2,6}/", $tld) === 1;
    }
    private function validDomain(string $domain): bool
    {
        return preg_match("/[a-z\d]+(?:-[a-z\d]+)*/", $domain) === 1;
    }
    private function validLocal(string $local): bool
    {
        return preg_match('/[a-z\d]+[\w.-]*/', $local) === 1;
    }

    private function containAtSign(string $email): bool
    {
        return preg_match('/@/', $email) === 1;
    }
    private function containDot(string $fullDomain): bool
    {
        return preg_match('/\./', $fullDomain) === 1;
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
        return preg_match('/[a-z]/', $password) === 1;
    }
    private function containCapitalLetter($password): bool
    {
        return preg_match('/[A-Z]/', $password) === 1;
    }

    private function containInt($password): bool
    {
        return preg_match('/\d/', $password) === 1;
    }
    private function containSpecialChar($password): bool
    {
        return preg_match('/[\W_]/', $password) === 1;
    }
    private function notContainSpaces($password): bool
    {
        return !preg_match('/\s/', $password);
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