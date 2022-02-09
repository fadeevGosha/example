<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\User;
use App\Services\IArticleContentProvider;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private IArticleContentProvider $articleContentProvider;

    private static array $articleTitles =
    [
        'Есть ли жизнь после девятой жизни?',
        'Когда в машинах поставят лоток?',
        'В погоне за красной точкой',
        'В чем смысл жизни сосисок'
    ];

    private static array $articleImages =
        [
            'article-1.jpeg',
            'article-2.jpeg',
            'article-3.jpeg',
            'article-4.jpeg',
            'article-5.jpeg'
        ];

    public function __construct(IArticleContentProvider $articleContentProvider)
    {
        $this->articleContentProvider = $articleContentProvider;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article) use ($manager)
        {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setBody($this->articleContentProvider->get(1).$this->faker->paragraph($this->faker->numberBetween(2, 5), true))
                ->setImage($this->faker->randomElement(self::$articleImages))
                ->setAuthor($this->getRandomReference(User::class))
                ->setVoteCount($this->faker->numberBetween(0, 10));

            if($this->faker->boolean(70))
            {
                $date = $this->faker->dateTimeBetween('-100 days', '-1 days');
                $article->setPublishedAt(new \DateTimeImmutable($date->format('d.m.Y H:i:s')));
            }

            $tags = [];

            for ($i = 0; $i<$this->faker->numberBetween(0, 5); $i++)
            {
                $tags[] = $this->getRandomReference(Tag::class);
            }
            foreach ($tags as $tag)
            {
                $article->addTag($tag);
            }
        });
    }

    public function getDependencies(): array
    {
        return [TagFixtures::class, UserFixtures::class];
    }
}
