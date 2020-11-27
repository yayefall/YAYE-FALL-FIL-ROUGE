<?php

namespace App\DataFixtures;

use App\Entity\Profilsortie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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
