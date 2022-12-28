<?php

namespace App\DataFixtures;

use App\Entity\Actors;
use App\Entity\Spectacles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Cocur\Slugify\Slugify;
use Faker;

class SpectaclesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        /*---------------------- GET EACH ACTORS OBJECTS TO IMPLEMENTS IN THE SHOWS -----------------*/
        $actors = $manager->getRepository(Actors::class)->findAll();



        $faker = Faker\Factory::create('fr_FR');
        $slugify = new Slugify();
        $actors = $manager->getRepository(Actors::class)->findAll();
        $index = 0;
        while($index < 5){
            $spectacle = new Spectacles();
            $spectacle->setTitre($this->data[$index][0]);
            $spectacle->setAuthor($this->data[$index][1]);
            $spectacle->setPeriod($this->data[$index][2]);
            $spectacle->setDescription($this->data[$index][3]);
            $spectacle->setStartDate(date_create_from_format('d/m/Y', $this->data[$index][4]));
            $spectacle->setEndDate(date_create_from_format('d/m/Y', $this->data[$index][5]));
            $spectacle->setSlug($slugify->slugify($this->data[$index][0]));
            $spectacle->setImageName($slugify->slugify($this->data[$index][0]) . '.jpg');
            $spectacle->addActor($actors[mt_rand(0, 14)]);
            $spectacle->addActor($actors[mt_rand(0, 14)]);
            $spectacle->addActor($actors[mt_rand(0, 14)]);
            $spectacle->addActor($actors[mt_rand(0, 14)]);
            $index++;
            $manager->persist($spectacle);
        }
        $manager->flush();
    }




private array $data = [
                [
                "Piège pour un homme seul",
                "Robert Thomas",
                "du 30/09 au 16/10",
                "Un jeune marié – en voyage de noces dans un village montagnard – signale la disparition de sa jeune épouse à la police. En effet, celle-ci n'est pas rentrée depuis quelques jours, à la suite d'une dispute, et il s'inquiète.
                        Lorsque le curé du village arrive et dit au mari qu'il a retrouvé sa femme et qu'elle est là, derrière la porte, la stupéfaction du mari est totale : cette femme qui se présente comme étant sa femme n'est pas la sienne. Or, comble de malheur, personne ne connaît la « vraie » Mme Corban, étant donné la nouveauté de cette relation. Cette Mme Corban affirme haut et fort que son mari est amnésique et pour confirmer ses dires, elle se prête à un interrogatoire en règle et obtient une note parfaite. Est-il fou ou une bande de malfaiteurs s’acharnent-ils sur lui ?
                        Une histoire rocambolesque suit aussitôt, où le rire et le mystère se croisent au fil des minutes et où le spectateur a parfois lui aussi l'impression de se retrouver dans le piège...",
                  "30/09/2022",
                  "16/10/2022"
                ],
                [
                "La dégustation",
                "Ivan Calbérac",
                "du 11/11 au 27/11",
                "Divorcé du genre bourru, et célibataire depuis trop longtemps, Jacques tient seul une petite cave à vins. Hortense, engagée dans l’associatif, tout proche de finir vieille fille, débarque un jour dans sa boutique et décide de s’inscrire à un atelier dégustation.
                        Mais pour que deux âmes perdues se reconnaissent, il faut parfois un petit miracle. Ce miracle s’appellera Steve, un jeune en liberté conditionnelle, qui, contre toute attente, va les rapprocher.
                        Et quand trois personnes issues d’univers si différents se rencontrent, c’est parfois un grand bonheur… Ou un chaos total. Chacun à leur manière, ils vont sérieusement déguster !",
                "11/11/2022",
                    "27/11/2022"
                ],
                [
                "La Revue 2023",
                "Les Molières & Mocassins",
                "du 30/12 au 22/01/2023",
                "Voici la 25e édition qui s'annonce drôle, piquante et plus déjantée que jamais.
                        au travers d'une trentaine de numéros dansés et chantés, les comédiens du Petit Théâtre de la Ruelle de Lodelinsart feuillettent dans le rire et le délire l'actualité carolo de l'année écoulée.",
                "30/12/2022",
                    "22/01/2023"
                ],
                [
                "Sur un air de tango",
                "Isabelle de Toledo",
                "du 17/03 au 02/04",
                "Pierre dirige un restaurant de bord de mer. Sa vie se borne à travailler dur, animé par le seul désir de rendre heureux sa femme Alice et leurs enfants. Max, son père, éternel jeune homme vit sa retraite entre ses copains, l'établissement de son fils et le souvenir de sa femme disparue.",
                "17/03/2023",
                    "02/04/2023"
                ],
                [
                "La nuit des dupes",
                "Michel Heim",
                "du 19/05 au 11/06",
                "Louis XIII n’a pas d’héritier et ne baise plus sa femme, la trop prude Anne d’Autriche. Sa mère, l’intrigante Marie de Médicis, compte en profiter pour le faire abdiquer en faveur de Gaston d’Orléans. C’est compter sans le fourbe Richelieu et le séduisant Duc de Buckingham.
                        Mais que vient faire d’Artagnan dans cette galère ?",
                    "19/05/2023",
                    "11/06/2023"
                ]
];

}

