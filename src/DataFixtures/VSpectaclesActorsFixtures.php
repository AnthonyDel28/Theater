<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VSpectaclesActorsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // GETTING THE ACTORS DATA USING THE REFERENCES //

        $jacques = $this->getReference('Jacques Delmeire');
        $salvatore = $this->getReference('Salvatore Vullo');
        $agnes = $this->getReference('Agnès Piantadosi');
        $jacquesD = $this->getReference('Jacques Dutrifoy');
        $christelle = $this->getReference('Christelle Letroye');
        $muriel = $this->getReference('Muriel Godefroid');
        $beatrice = $this->getReference('Béatrice Schaffrien');
        $alexandra = $this->getReference('Alexandra Delmotte');
        $carine = $this->getReference('Carine Stratta');
        $jacqueline = $this->getReference('Jacqueline Deremince');
        $raffaele = $this->getReference('Raffaele Vullo');
        $gerard = $this->getReference('Gérard Monseux');
        $michael = $this->getReference('Michael Peigneux');
        $cindy = $this->getReference('Cindy Detrogh');
        $francis = $this->getReference('Francis Dehasseleer');
        $alain = $this->getReference('Alain Boivin');
        $wesley = $this->getReference('Wesley Mayence');

        // GETTING THE SPECTACLES DATA USING THE REFERENCES //

        $show1 = $this->getReference('show-1');
        $show2 = $this->getReference('show-2');
        $show3 = $this->getReference('show-3');
        $show4 = $this->getReference('show-4');
        $show5 = $this->getReference('show-5');

        /*------------------------------------------*/

        /*---------------- ADDING ACTORS TO EACH SPECTACLE --------------------*/

            $show1->addActor($jacques);
            $jacques->addSpectacle($show1);
            $show1->addActor($salvatore);
            $salvatore->addSpectacle($show1);
            $show1->addActor($agnes);
            $agnes->addSpectacle($show1);
            $show1->addActor($jacquesD);
            $jacquesD->addSpectacle($show1);
            $show1->addActor($cindy);
            $cindy->addSpectacle($show1);
            $show1->addActor($francis);
            $francis->addSpectacle($show1);

            //---------------------------------//


            $show2->addActor($jacques);
            $jacques->addSpectacle($show2);
            $show2->addActor($salvatore);
            $salvatore->addSpectacle($show2);
            $show2->addActor($agnes);
            $agnes->addSpectacle($show2);
            $show2->addActor($jacquesD);
            $jacquesD->addSpectacle($show2);
            $show2->addActor($michael);
            $michael->addSpectacle($show2);

            //--------------------------------//

            $show3->addActor($jacquesD);
            $jacquesD->addSpectacle($show3);
            $show3->addActor($jacques);
            $jacques->addSpectacle($show3);
            $show3->addActor($salvatore);
            $salvatore->addSpectacle($show3);
            $show3->addActor($alexandra);
            $alexandra->addSpectacle($show3);
            $show3->addActor($muriel);
            $muriel->addSpectacle($show3);
            $show3->addActor($christelle);
            $christelle->addSpectacle($show3);
            $show3->addActor($carine);
            $carine->addSpectacle($show3);
            $show3->addActor($raffaele);
            $raffaele->addSpectacle($show3);
            $show3->addActor($jacqueline);
            $jacqueline->addSpectacle($show3);
            $show3->addActor($gerard);
            $gerard->addSpectacle($show3);
            $show3->addActor($beatrice);
            $beatrice->addSpectacle($show3);

            $show4->addActor($alexandra);
            $alexandra->addSpectacle($show4);
            $show4->addActor($salvatore);
            $salvatore->addSpectacle($show4);
            $show4->addActor($alain);
            $salvatore->addSpectacle($show4);


            $show5->addActor($jacques);
            $jacques->addSpectacle($show5);
            $show5->addActor($jacquesD);
            $jacquesD->addSpectacle($show5);
            $show5->addActor($salvatore);
            $salvatore->addSpectacle($show5);
            $show5->addActor($wesley);
            $wesley->addSpectacle($show5);

        $manager->persist($show1);
        $manager->persist($show2);
        $manager->persist($show3);
        $manager->persist($jacques);
        $manager->persist($agnes);
        $manager->persist($salvatore);
        $manager->persist($jacquesD);
        $manager->persist($christelle);
        $manager->persist($muriel);
        $manager->persist($beatrice);
        $manager->persist($alexandra);
        $manager->persist($michael);
        $manager->persist($gerard);
        $manager->persist($raffaele);
        $manager->persist($cindy);
        $manager->persist($carine);
        $manager->persist($francis);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ActorsFixtures::class, SpectaclesFixtures::class];
    }

    public function getOrder(): int
    {
        return 10; // smaller means sooner
    }
}
