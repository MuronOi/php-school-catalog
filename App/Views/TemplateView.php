<?php

namespace App\Views;

use App\logger\Logger;

class TemplateView implements ViewInterface
{
    protected $template;

    protected $data = [];

    private $logger;

    public function __construct(string $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
        $this->logger = new Logger();
    }

    public function render()
    {
        extract($this->data);

        try {
            $path = __DIR__ . '/../../views/' . $this->template . '.php';
            if (!file_exists($path)) {
                throw new \Exception('View file does not exists');
            }
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage() . 'File: ' . $path, 'error');
        }


        ob_start();
        require __DIR__ . '/../../views/' . $this->template . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../../views/layout.php';
    }
}
