<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class Response implements ResponseInterface
{
    public function getResponseData() : array
    {
        return (array)$this;
    }

    public function getResponseCode() : int
    {
        return SymfonyResponse::HTTP_OK;
    }

    public function jsonSerialize(): array
    {
        return $this->getResponseData();
    }    
}