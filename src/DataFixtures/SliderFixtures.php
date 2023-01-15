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
        $index = 1;
        while($index <= 3){

            $slider = new Slider();
            $slider->setTitle('La Revue 2023');
            $slider->setSubTitle('test test test');
            $slider->setUpdatedAt(new \DateTimeImmutable());
            $slider->setImageName($index . '.jpg');
            $manager->persist($slider);
            $index++;
        }
        $manager->flush();
    }


}