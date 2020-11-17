<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Users;
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

            $user = new Users();

            $user->setNom($faker->lastName);
            $user ->setPrenom($faker->firstName);
            $user->setGenre($faker->randomElement(['Homme', 'Femme']));
            $user->setUsername($faker->userName);
            $user ->setEmail($faker->email);
            $user ->setTelephone($faker->phoneNumber);
            $user->setPhoto("default.png");
            $user->setArchivage(0);
            $user ->setProfils($this->getReference($i));
            $hash = $this->encoder->encodePassword($user, "password");
            $user ->setPassword($hash);

            $manager->persist($user);
        }
            $manager->flush();
        
    }



}
