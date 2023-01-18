<?php

namespace App\DataFixtures;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private object $hasher;
    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
            $slugify = new Slugify();
            $index = 0;
            while($index < 4){
                $user = new User();
                $user->setFirstName($this->data[$index][0]);
                $user->setLastName($this->data[$index][1]);
                $user->setEmail($this->data[$index][2]);
                $user->setPassword($this->hasher->hashPassword($user, 'password'));
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setImageName($this->data[$index][0] . '-' . $this->data[$index][1] . '.jpg');
                $user->setSlug($slugify->slugify($this->data[$index][0] . ' ' . $this->data[$index][1]));
                $user->setRoles(['ROLE_SUPER_ADMIN']);
                $user->setActive(TRUE);
                $manager->persist($user);
                $index++;
            }
            $manager->flush();
    }

    public function getOrder()
    {
        return 1;
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
        ],
        [
            "Pat",
            "Mar",
            "patmar@gmail.com",
            "password",
        ]
    ];
}
