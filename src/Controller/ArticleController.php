<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\IArticleRepository;
use App\Services\IArticleContentProvider;
use App\Services\IArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @var IArticleService
     */
    private IArticleService $articleService;
    /**
     * @var IArticleContentProvider
     */
    private IArticleContentProvider $articleContentProvider;

    public function __construct(
        IArticleService $articleService,
        IArticleContentProvider $articleContentProvider
    ) {
        $this->articleService = $articleService;
        $this->articleContentProvider = $articleContentProvider;
    }

    /**
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function index(IArticleRepository $articleRepository): Response
    {
        return $this->render(
            'base.html.twig',
            ['articles' => $articleRepository->findLatestPublished()]
        );
    }

    /**
     * @Route("/articles/{slug}", name="app_article_view")
     * @param Article $article
     * @return Response
     */
    public function view(Article $article): Response
    {
        return $this->render(
            "/articles/view.html.twig",
            [
                'article' => $article,
            ]
        );
    }

    /**
     * @Route("/articles/{articleId}/paragraphs/{countParagraphs}",
     * requirements={"articleId"="\d+", "countParagraphs"="\d+"}, name="app_show_generate_text", methods={"GET"})
     * @param int $articleId
     * @param int $countParagraphs
     * @param Request $request
     * @return Response
     */
    public function showGeneratedText(
        int $articleId,
        int $countParagraphs,
        Request $request
    ): Response {
        $word = $request->get('word') ?? null;
        $wordsCount = $request->get('wordsCount') ?? 0;

        $article = array_merge(
            $this->articleService->getArticleById($articleId),
            ['comments' => ['Комментарий-1', 'Комментарий-2', 'Комментарий-3', 'Комментарий-4']]
        );

        $article['text'] = $this->articleContentProvider->get($countParagraphs, $word, $wordsCount);
        return $this->render("/articles/view.html.twig", ['article' => $article]);
    }

    /**
     * @Route("/articles/article_content", name="app_article_content")
     * @param Request $request
     * @param IArticleContentProvider $articleContentProvider
     * @return Response
     */
    public function getArticleContent(Request $request, IArticleContentProvider $articleContentProvider): Response
    {
        $countParagraphs = $request->query->get('countParagraphs') !== '' ? $request->query->get('countParagraphs') : 0;
        $word = $request->query->get('word') !== '' ? $request->query->get('word') : null;

        $wordsCount = $request->query->get('wordsCount') !== '' ? $request->query->get('wordsCount') : 0;
        $text = null;

        if ($countParagraphs) {
            $text = $articleContentProvider->get($countParagraphs, $word, $wordsCount, false);
        }

        return $this->render("/articles/article_content.html.twig", ['text' => $text]);
    }
}