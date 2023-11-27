<?php

namespace Infrastructure\Symfony\Adapter\View;

use Application\Interface\ViewModel;

class CliViewModel extends ViewModel
{
    private string $outputMessage = '';
    private int $returnCode;

    public function __construct(private \Closure $handler)
    {
        // Get message and status code when constructing
        $this->invokeHandler();
    }

    // This method is used to invoke the handler and store the returned data
    private function invokeHandler(): void
    {
        $response = ($this->handler)();

        $this->outputMessage = $response['message'] ?? '';
        $this->returnCode = $response['status_code'] ?? 1;
    }

    public function getResponse(): int
    {
        $this->outputMessage;
        return $this->getReturnCode();
    }

    public function getReturnCode(): int
    {
        return $this->returnCode;
    }
}
