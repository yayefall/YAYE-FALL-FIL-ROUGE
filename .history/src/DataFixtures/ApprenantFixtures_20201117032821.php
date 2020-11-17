<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApprenantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        if ($libelle == "Apprenant") {

            $user = new Apprenant();
            $user->setAdresse($faker->address)
                ->setCategorie($faker->randomElement(['Faible', 'Abien', 'Exellent', 'Tbien']))
                ->setStatut('Actif')
                ->setInfocomplementaitre($faker->text)
                ->setProfilsortie($faker->randomElement($tabEntity));
        }
        $manager->flush();
    }
}
