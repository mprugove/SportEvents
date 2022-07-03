<?php

declare(strict_types = 1);

namespace Core;

use Exception;

class View
{
    public const VIEW_EXTENSION = ".phtml";

    public function render(string $view, array $data = [], array $errors = []): string
    {
        include VIEW_PATH . $view . self::VIEW_EXTENSION;

        ob_start();

        try
        {
            extract($data, EXTR_SKIP);

            if (isset($errors) && $errors != null)
            {
                extract($errors);
            }

            include VIEW_PATH . "$view" . self::VIEW_EXTENSION;
        }
        catch (Exception $e)
        {
            ob_end_clean();
            echo 'view not found';
            throw $e;
        }

        return ob_get_clean() ?: "";
    }
}
