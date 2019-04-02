<?php

namespace App\Views;

class TemplateView
{
    /**
     * TemplateView constructor.
     */
    public function __construct($view_name, $forms)
    {
        $path = __DIR__ . '/../../views/' . $view_name . '.php';

        ob_start();

        $view = include_once $path;
        $content = ob_get_contents();

        ob_clean();

        $layout = include_once __DIR__ . '/../../views/layout.php';
        $content = ob_get_contents();

        ob_end_clean();

        echo $content;

    }
}
