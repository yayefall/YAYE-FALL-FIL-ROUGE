<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApprenantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 4; $i++) {

            $user = new A();

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
