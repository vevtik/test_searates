<?php

namespace app\lib;

class Request
{
    private array $post;
    private array $get;
    private string $body;
    private string $method;
    private string $uri;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->body = file_get_contents('php://input');
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @return array|false|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed|string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed|string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
