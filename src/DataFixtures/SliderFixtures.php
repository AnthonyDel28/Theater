<?php

namespace App\DataFixtures;

use App\Entity\Actors;
use App\Entity\Slider;
use App\Entity\Spectacles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Cocur\Slugify\Slugify;
use Faker;

class SliderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $slider1 = new Slider();
        $slider1->setTitle('La Revue 2023');
        $slider1->setActive(1);
        $slider1->setSubTitle('Les Qataris débarquent à Lodelinsart!');
        $slider1->setUpdatedAt(new \DateTimeImmutable());
        $slider1->setImageName('1.jpg');
        $manager->persist($slider1);

        $slider2 = new Slider();
        $slider2->setTitle('La Revue 2023:');
        $slider2->setActive(0);
        $slider2->setSubTitle('Mieux vaut Qatar que jamais!');
        $slider2->setUpdatedAt(new \DateTimeImmutable());
        $slider2->setImageName('2.jpg');
        $manager->persist($slider2);

        $slider3 = new Slider();
        $slider3->setTitle('Bienvenue sur notre nouveau site web');
        $slider3->setActive(0);
        $slider3->setSubTitle('Bonne visite!');
        $slider3->setUpdatedAt(new \DateTimeImmutable());
        $slider3->setImageName('3.jpg');
        $manager->persist($slider3);

        $manager->flush();
    }


}