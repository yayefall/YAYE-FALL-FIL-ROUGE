<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilsortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $profilsortie = ['Developpeur Front', 'CMS', 'Integrateur', 'Data', 'Designer', 'Fullback', 'CM'];
        $tabEntity = [];
        //profilsortie
        foreach ($profilsortie as $libelle) {
            $profilsortie = new Profilsortie();
            $profilsortie->setLibelle($libelle)
                ->setArchivage(0);
            $tabEntity[] = $profilsortie;
            $manager->persist($profilsortie);
        }
        $manager->flush();
    }
}
