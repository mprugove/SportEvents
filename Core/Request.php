<?php

declare(strict_types = 1);

namespace Core;

class Request
{
    private $requestMethod = 'GET';
    private $urlArray = [];
    private $url = "/";

    public function __construct()
    {
        $this->url = $this->convertToString();
        $this->urlArray = $this->convertToArray();
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
    }

    private function convertToArray(): array
    {
        $url = rtrim($_SERVER['REQUEST_URI'] ?? '', '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        array_shift($url);
        array_shift($url); // Removes subfolder from request
        return !empty($url) ? $url : [];
    }

    private function convertToString(): string
    {
        $url = rtrim($_SERVER['REQUEST_URI'] ?? '', '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        array_shift($url);
        array_shift($url);
        $url = implode('/', $url);
        return !empty($url) ? $url : '/';
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function getUrlArray(): array
    {
        return $this->urlArray;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
