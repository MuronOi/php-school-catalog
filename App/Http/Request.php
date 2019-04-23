<?php

namespace App\Http;

/**
 * Class Request
 * @package App\Http
 */
class Request implements RequestInterface
{
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    /**
     * @return mixed
     */
    public function getPath()
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }
    /**
     * @return mixed
     */
    public function getQueryParams()
    {
        return $_GET;
    }
    /**
     * @return mixed
     */
    public function getPostData()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $data = $this->getPutData();
        } else {
            $data = $_POST;
        }
        return $data;
    }
    /**
     * @return array
     */
    public function getPutData()
    {
        $_PUT = [];

        if (strpos($_SERVER['CONTENT_TYPE'], 'multipart') !== false) {
            $_PUT = $this->getPutDataFormDataType() ;
        } elseif (strpos($_SERVER['CONTENT_TYPE'], 'application') !== false) {
            $_PUT = $this->getPutDataXWwwFormUrlencoded() ;
        }
        return $_PUT;
    }
    /**
     * @return array
     */
    private function getPutDataFormDataType (): array
    {
        $raw_data = file_get_contents('php://input');
        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data = [];

        foreach ($parts as $part) {
            if ($part == "--\r\n") {
                break;
            }
            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);
            // Parse the headers list
            $raw_headers = explode("\r\n", $raw_headers);
            $headers = [];
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }
            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                preg_match('/^(.+); *name="([^"]+)"/', $headers['content-disposition'],$matches);
                list(, $type, $name) = $matches;
                $data[$name] = substr($body, 0, strlen($body) - 2);
            }
        }
        return $data;
    }
    /**
     * @return array
     */
    private function getPutDataXWwwFormUrlencoded(): array
    {
        $putdata = file_get_contents('php://input');
        $exploded = explode('&', $putdata);
        foreach($exploded as $pair) {
            $item = explode('=', $pair);
            if(count($item) == 2) {
                $data[urldecode($item[0])] = urldecode($item[1]);
            }
        }
        return $data;
    }
}
