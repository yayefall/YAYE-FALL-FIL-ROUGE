<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {

            $user = new Users();

            $user->setNom($faker->lastName);
            $user ->setPrenom($faker->firstName);
            $user->setGenre($faker->randomElement(['Homme', 'Femme']));
            $user->setUsername($faker->userName);
            $user ->setEmail($faker->email);
            $user ->setTelephone($faker->phoneNumber);
            $user->setArchivage(0);
            $user ->setProfils($this->getReference(rand(0, 3)));
            $hash = $this->encoder->encodePassword($user, "password");
            $user ->setPassword($hash);

            $manager->persist($user);
        }
            $manager->flush();
        
    }



}
