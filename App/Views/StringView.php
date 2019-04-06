<?php

namespace App\Views;

class StringView implements ViewInterface
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function render()
    {
        echo $this->string;
    }
}
