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
        $slider1->setSubTitle('test test test');
        $slider1->setUpdatedAt(new \DateTimeImmutable());
        $slider1->setImageName('1.jpg');
        $slider1->setTextPosition('right');
        $manager->persist($slider1);

        $slider2 = new Slider();
        $slider2->setTitle('La Revue 2023');
        $slider2->setActive(0);
        $slider2->setSubTitle('test test test');
        $slider2->setUpdatedAt(new \DateTimeImmutable());
        $slider2->setImageName('2.jpg');
        $slider2->setTextPosition('right');
        $manager->persist($slider2);

        $slider3 = new Slider();
        $slider3->setTitle('La Revue 2023');
        $slider3->setActive(0);
        $slider3->setSubTitle('test test test');
        $slider3->setUpdatedAt(new \DateTimeImmutable());
        $slider3->setImageName('3.jpg');
        $slider3->setTextPosition('right');
        $manager->persist($slider3);

        $manager->flush();
    }


}