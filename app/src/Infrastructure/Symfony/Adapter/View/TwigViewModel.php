<?php

namespace Infrastructure\Symfony\Adapter\View;

use Application\Interface\ViewModel;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TwigViewModel extends ViewModel
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private Environment $twig,
        private string $template,
        private array $data
    ) {
    }

    public function getResponse(): Response
    {
        return new Response($this->twig->render($this->template, $this->data));
    }
}
