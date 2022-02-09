<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\Request;

interface ResponseFactoryInterface
{
    public function createResponseForRequest(Request $request) : ResponseInterface;
}