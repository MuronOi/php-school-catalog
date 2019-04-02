<?php

namespace App\Controllers;

use App\Views\TemplateView;

class FormController
{
    public function index($params = [])
    {

        // ...

        return new TemplateView(
            'view_name', [
            'title' => 'My awesome page',
            'forms' => [],// ...
        ]);
    }

    public function view($params = [])
    {
        p($params);

        return 'Controller View';

    }
}
