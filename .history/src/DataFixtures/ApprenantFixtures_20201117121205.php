<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Apprenant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantFixtures extends Fixture implements DependentFixtureInterface
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

            $user = new Apprenant();

            $user->setAdresse($faker->address);
            $user->setCategorie($faker->randomElement(['Faible', 'Abien', 'Exellent', 'Tbien']));
            $user->setStatut('Actif');
            $user->setInfoComplementaire($faker->text);
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
    Public function getdDpendentFixture(){

    }
}
