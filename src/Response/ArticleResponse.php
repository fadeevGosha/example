<?php


namespace App\Responses;

use App\Entity\Article;
use App\Response\Response;
use OpenApi\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Models\ArticleModel;

class ArticleResponse extends Response
{
    /**
     * @SWG\Property(type="boolean", description="Result of operation", example=true)
     * @Groups({"swagger"})
     */
    public bool $result = true;

    /**
     * @SWG\Property(type="object", ref=@Model(type=ArticleModel::class, groups={"swagger"}))
     * @Groups({"swagger"})
     */
    public ArticleModel $article;

    public function __construct(Article $article)
    {
        $this->article = new ArticleModel($article);
    }
}