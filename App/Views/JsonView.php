<?php


namespace App\Views;


class JsonView implements ViewInterface
{
    private $params;

    /**
     * JsonView constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }


    public function render()
    {
        var_dump(json_decode($this->params));

    }
}