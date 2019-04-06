<?php

namespace App\Http;

interface RequestInterface
{
    public function getMethod();

    public function getPath();

    public function getQueryParams();

    public function getPostData();
}
