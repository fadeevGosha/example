<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleFormType;
use App\Repository\IArticleRepository;
use App\Repository\ICommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ArticlesController
 * @package App\Controller\Admin
 * @method User|null getUser()
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="app_admin_articles_list")
     * @IsGranted("ROLE_ADMIN_ARTICLE"))
     * @throws Exception
     */
    public function index(
        Request $request,
        IArticleRepository $articleRepository,
        PaginatorInterface $paginator
    ): Response {
        $pagination = $paginator->paginate(
            $articleRepository->latest(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("admin/articles/article.index.html.twig", ['pagination' => $pagination]);
    }

    /**
     * @Route("/admin/articles/create", name="app_admin_articles_create")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     * @throws Exception
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('flash_message', 'Статья успешно создана');
            return $this->redirectToRoute('app_admin_articles_list');
        }

        return $this->render(
            "admin/articles/article.create.html.twig",
            ['articleForm' => $form->createView(), 'showError' => !$form->getErrors()]
        );
    }

    /**
     * @Route("/admin/articles/{id}/edit", name="app_admin_articles_edit")
     * @IsGranted("MANAGE", subject="article")
     * @throws Exception
     */
    public function edit(
        Article $article,
        Request $request,
        EntityManagerInterface $entityManager,
        ICommentRepository $commentRepository,
        SluggerInterface $slugger

    ): Response {
        $form = $this->createForm(ArticleFormType::class, $article, ['enabled_published_at' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            /** @var UploadedFile|null $image */
            $image = $form->get('image')->getData();

            $fileName = $slugger
                ->slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                ->append('-' . uniqid())
                ->append('.' . $image->guessExtension())
                ->toString();

            $newFile =  $image->move($this->getParameter('article_uploads_dir'), $fileName);
            $article->setImage($newFile->getFilename());

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('flash_message', 'Статья успешно изменена');
            return $this->redirectToRoute('app_admin_articles_edit', ['id' => $article->getId()]);
        }


        return $this->render(
            "admin/articles/article.edit.html.twig",
            [
                'articleForm' => $form->createView(),
                'showError' => !$form->getErrors(),
                'comments' => $commentRepository->findAll()
            ]
        );
    }
}