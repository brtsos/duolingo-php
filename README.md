# DuolingoPHP

DuolingoPHP is a library to interact with Duolingo's API with PHP.

## Installation

`composer require arnaudlier/duolingo-php`

## Example usage

```php
// With password

$duolingo = new \ArnaudLier\DuolingoPHP\Client(
    $identifier = 'ArnaudLier',
    $password = 'abcdefghijklmnopqrstuvwxyz',
);

// Store JWT for future usage...
$jwt = $duolingo->getJwt();

// With JWT
$duolingo = new \ArnaudLier\DuolingoPHP\Client(
    $identifier = 'ArnaudLier',
    $jwt = $jwt,
);

// Retrieve user information
$user = $duolingo->getUser();
$user = $duolingo->getUser('ArnaudLier');

echo "User $user->name has a streak of $user->streak and a total XP of $user->totalXp"
```