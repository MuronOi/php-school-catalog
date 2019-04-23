<?php


namespace App\Views;


use App\logger\Logger;

class JsonView implements ViewInterface
{
    protected $data;
    protected $headers = [];
    protected $responseCode;
    private $logger;

    public function __construct($data = '', $headers = [], $responseCode = 200)
    {
        $this->data = $data;
        $this->headers = $headers;
        $this->responseCode = $responseCode;
        $this->logger = new Logger();
    }

    public function render()
    {

        $this->data = json_encode($this->data);

        foreach ($this->headers as $header){
            header($header);
        }
        http_response_code($this->responseCode);
        echo ($this->data);
    }
}

