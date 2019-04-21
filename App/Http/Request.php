<?php

namespace App\Http;

class Request implements RequestInterface
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath()
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function getPostData()
    {
        return $_POST;
    }

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

    private function getPutDataFormDataType (): array
    {
        $raw_data = file_get_contents('php://input');
        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data = [];

        foreach ($parts as $part) {
            if ($part == "--\r\n") break;

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
//            p($headers, ' heders');
            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                list(, $type, $name) = $matches;
                isset($matches[4]) and $filename = $matches[4];

                // handle your fields here
                switch ($name) {
                    // this is a file upload
                    case 'userfile':
                        file_put_contents($filename, $body);
                        break;

                    // default for all other files is to populate $data
                    default:
                        $data[$name] = substr($body, 0, strlen($body) - 2);
                        break;
                }
            }
        }
        return $data;
    }

    protected function getPutDataXWwwFormUrlencoded(): array
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
