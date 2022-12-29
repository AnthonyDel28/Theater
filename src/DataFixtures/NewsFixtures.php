<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Cocur\Slugify\Slugify;
use Faker\Factory;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $slugify = new Slugify();
        $faker = Factory::create('fr_FR');
        $index = 0;
        while($index <= 10){
            $news = new News();
            $title = $faker->words(mt_rand(3, 6), true);
            $news->setTitle($title);
            $news->setCreatedAt(new \DateTimeImmutable());
            $news->setUpdatedAt(new \DateTimeImmutable());
            $news->setContent($faker->words(mt_rand(55, 100), true));
            $news->setImageName($slugify->slugify($title) . 'jpg');
            $news->setIsPublished(TRUE);
            $news->setSlug($slugify->slugify($title));
            $manager->persist($news);
            $index++;
        }
        $manager->flush();
    }
}
