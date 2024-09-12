## Program służący do walidacji adresu email i hasła

## Przykład użycia

```php
$validator = new UserValidator();
$email = "test@mail.gov";
$password = "Password12!";
if ($validator->validateEmail($email)) {
    echo "Email is valid.\n";
} else {
    echo "Email is invalid.\n";
}

if ($validator->validatePassword($password)) {
    echo "Password is valid.\n";
} else {
    echo "Password is invalid.\n";
}
