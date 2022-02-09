<?php

namespace App\Request;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use App\Response\ResponseInterface;

interface RequestHandlerInterface
{
    public function handle(Request $request, Article $article) : ResponseInterface;
}