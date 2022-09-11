<?php

declare(strict_types = 1);

namespace App\Model;

use Core\Data\Database;

class User extends AbstractModel
{
    protected static $tableName = 'users';

    public static function isEmailAvailable($email): bool
    {
        $user = self::getOne('email', $email);

        return $user->getEmail() ? true : false;
    }
}
