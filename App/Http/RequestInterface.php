<?php

namespace App\Http;

/**
 * Interface RequestInterface
 * @package App\Http
 */
interface RequestInterface
{
    /**
     * @return mixed
     */
    public function getMethod();

    /**
     * @return mixed
     */
    public function getPath();

    /**
     * @return mixed
     */
    public function getQueryParams();

    /**
     * @return mixed
     */
    public function getRequestBodyData();

    /**
     * @return mixed
     */
    public function getPutData();
}
