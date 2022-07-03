<?php

namespace Core;

use App\Model\User;
use Core\Data\DataObject;

class Session extends DataObject
{
    private static $instance;
    private $currentUser;

    public function __construct(array $data = [])
    {
        if ($userId = $_SESSION['user_id'] ?? null) {
            $user = User::getOne('id', $userId);
            $this->currentUser = $user->getId() ? $user : null;
        }
    }

    protected function __clone() { }

    public function __set($key, $value)
    {
        parent::__set($key, $value);
        $_SESSION[$key] = $value;
    }

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function resetFormInput()
    {
        unset($_SESSION['form_data']);
        unset($_SESSION['form_errors']);
    }
}
