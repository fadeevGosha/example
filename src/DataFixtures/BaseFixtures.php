<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{
    protected Generator $faker;
    protected ObjectManager $manager;
    private array $refetencesIndex = [];

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        $this->loadData($manager);
    }

    abstract public function loadData(ObjectManager $manager);

    protected function create(string $className, callable $factory)
    {
        $entity = new $className();
        $factory($entity);

        $this->manager->persist($entity);
        return $entity;
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for($i = 0; $i < $count; $i++) {
           $entity =  $this->create($className, $factory);

           $this->addReference("$className|$i", $entity);
        }

        $this->manager->flush();
    }

    protected function getRandomReference(string $className): object
    {
        if(!isset($this->refetencesIndex[$className]))
        {
            $this->refetencesIndex[$className] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $reference)
            {
                if(strpos($key, $className.'|') === 0)
                {
                    $this->refetencesIndex[$className][] = $key;
                }
            }
        }

        if(empty($this->refetencesIndex[$className]))
        {
            throw new \Exception('Не найдены ссылки на класс: '. $className);
        }

        return $this->getReference($this->faker->randomElement($this->refetencesIndex[$className]));
    }
}
