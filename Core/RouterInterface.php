<?php

declare(strict_types = 1);

namespace Core;

interface RouterInterface
{
    public function match(string $requestMethod, array $url);
}
