<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Services\IArticleContentProvider;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ArticleController
 * @package App\Controller\Api
 */
class ArticleController extends AbstractController
{
    public const VOTE_TYPE_UP = 'up';
    /**
     * @var IArticleContentProvider
     */
    private IArticleContentProvider $articleContentProvider;

    public function __construct(IArticleContentProvider $articleContentProvider)
    {
        $this->articleContentProvider = $articleContentProvider;
    }

    /**
     * @Route("/api/article", name="api_article", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function getText(Request $request): Response
    {
        $countParagraphs = $request->get('countParagraphs');

        if ($countParagraphs > 25) {
            throw new NotFoundHttpException("The maximum number of paragraphs is 25");
        }

        $word = $request->get('word') ?? null;
        $wordsCount = $request->get('wordsCount') ?? 0;

        $text = $this->articleContentProvider->get($countParagraphs, $word, $wordsCount);
        return new JsonResponse(['text' => $text], 200, ['Content-Type' => 'application/json; charset=utf-8']);
    }

    /**
     * @param Article $article
     * @param string $type
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @Route("articles/{slug}/vote/{type<up|down>}", name="vote", methods={"POST"})
     */
    public function vote(Article $article, string $type, LoggerInterface $logger, EntityManagerInterface $entityManager): Response
    {
        if ($type === static::VOTE_TYPE_UP) {
            $article->voteUp();
        } else {
            $article->voteDown();
        }

        $entityManager->flush();
        return $this->json(['voteCount' => $article->getVoteCount()]);
    }
}
