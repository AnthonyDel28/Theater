<?php

namespace App\DataFixtures;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private object $hasher;
    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
            $slugify = new Slugify();
            $index = 0;
            while($index < 3){
                $user = new User();
                $user->setFirstName($this->data[$index][0]);
                $user->setLastName($this->data[$index][1]);
                $user->setEmail($this->data[$index][2]);
                $user->setPassword($this->data[$index][3]);
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setImageName($slugify->slugify($this->data[$index][0] . ' ' . $this->data[$index][1] . '.jpg'));
                $user->setSlug($slugify->slugify($this->data[$index][0] . ' ' . $this->data[$index][1]));
                $user->setActive(TRUE);
                $manager->persist($user);
                $index++;
            }
            $manager->flush();
    }


    private array $data = [
        [
            "Anthony",
            "Delmeire",
            "anthonydelmeire2709@gmail.com",
            "password",
        ],
        [
            "Jacques",
            "Delmeire",
            "jacques@gmail.com",
            "password",
        ],
        [
            "Salvatore",
            "Vullo",
            "salvatore@gmail.com",
            "password",
        ]
    ];
}
