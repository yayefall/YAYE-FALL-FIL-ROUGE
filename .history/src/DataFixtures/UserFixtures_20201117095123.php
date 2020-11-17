<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 4; $i++) {

            $user = new User();

            $user->setNom($faker->lastName)
            $user ->setPrenom($faker->firstName)
            $user->setGenre($faker->randomElement(['Homme', 'Femme']))
               
                ->setPassword($password)
                ->setEmail($faker->email)
                ->setTelephone($faker->phoneNumber)
                ->setPhoto("default.png")
                ->setArchivage(0)
                ->setProfils($this->getReference($i));
                

            $manager->persist($user);

            $manager->flush();
        }
    }
}
