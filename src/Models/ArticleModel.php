<?php

namespace App\Models;

use App\Entity\Article;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as SWG;

/** 
 * @OA\Definition(
 *      title="Assessment",
 *      type="object", 
 *      required={
 *          "id", 
 *          "title",
 *      }
 * )
 */
class ArticleModel implements \JsonSerializable
{
    /**
     * @SWG\Property("integer")
     * @Groups({"swagger"})
     */
    public ?int $id;

    /**
     * @SWG\Property("string")
     * @Groups({"swagger"})
     */
    public ?string $title;


    public function __construct(
        Article $article
    )
    {
        $this->id = $article->getId();
        $this->title = $article->getTitle();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
