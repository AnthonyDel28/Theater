<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Cocur\Slugify\Slugify;
use Faker\Factory;

class NewsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $slugify = new Slugify();
        $faker = Factory::create('fr_FR');
        $authors = $manager->getRepository(User::class)->findAll();
        $index = 1;
        while($index <= 9){
            $news = new News();
            $title = $faker->words(mt_rand(3, 6), true);
            $news->setTitle($title);
            $news->setCreatedAt(new \DateTimeImmutable());
            $news->setUpdatedAt(new \DateTimeImmutable());
            $news->setSmallDescription($faker->words(mt_rand(15, 25), true));
            $news->setContent($faker->words(mt_rand(55, 100), true));
            $news->setImageName(mt_rand(1, 12) . '.jpg');
            $news->setIsPublished(TRUE);
            $news->setSlug($slugify->slugify($title));
            $news->setAuthor($authors[mt_rand(0,2)]);
            $manager->persist($news);
            $index++;
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
