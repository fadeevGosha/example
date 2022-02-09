<?php

namespace App\Handlers;

use App\Entity\Article;
use App\Response\ResponseInterface;
use App\Responses\ArticleResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleViewHandler  implements ArticleViewHandlerInterface
{
    public function handle(Request $request, Article $article): ResponseInterface
    {
        return new ArticleResponse($article);
    }
}
