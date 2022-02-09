<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Handlers\ArticleViewHandlerInterface;
use OpenApi\Annotations as SWG;
use App\Response\NotFoundResponse;
use App\Response\ResponseInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Response\ArticleResponse;
use App\Responses\UnauthorizedResponse;

/**
 * @SWG\Tag(name="Article")
 */
class ArticleViewController extends AbstractController
{
    private ArticleViewHandlerInterface $articleViewHandler;

    public function __construct(
        ArticleViewHandlerInterface $articleViewHandler
    )
    {
        $this->articleViewHandler = $articleViewHandler;
    }

    /**
     * @Route("/api/v1/article/{articleId}",
     *     name="article.manage.article.view", methods={"GET"}, requirements={"articleId"="\d+"})
     * @SWG\Response(
     *     response=200,
     *     description="Article complete",
     *     @Model(type=ArticleResponse::class, groups={"swagger"})
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Not found response",
     *     @Model(type=NotFoundResponse::class, groups={"swagger"})
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Failed authorization response",
     *     @Model(type=UnauthorizedResponse::class, groups={"swagger"})
     * )
     * @Security(name="Bearer")
     */
    public function __invoke(Request $request, Article $article): ResponseInterface {
        return $this->articleViewHandler->handle($request, $article);
    }
}
