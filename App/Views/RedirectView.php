<?php

namespace App\Views;

use App\logger\Logger;

class RedirectView implements ViewInterface
{
    private $url;
    private $logger;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->logger = new Logger();
    }

    public function render()
    {
        $this->logger->log('Redirect to:' . $this->url, 'info');
        header('Location: ' . $this->url);
    }
}
