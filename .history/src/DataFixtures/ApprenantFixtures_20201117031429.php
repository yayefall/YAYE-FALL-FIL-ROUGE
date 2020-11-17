<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Apprenant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ApprenantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        if ($this->getReference($i) == "Apprenant") {

            $user = new Apprenant();
            $user->setAdresse($faker->address)
                ->setCategorie($faker->randomElement(['Faible', 'Abien', 'Exellent', 'Tbien']))
                ->setStatut('Actif')
                ->setInfocomplementaire($faker->text);
               // ->setProfilsortie($faker->randomElement($tabEntity));
        }
        $manager->flush();
    }
}
