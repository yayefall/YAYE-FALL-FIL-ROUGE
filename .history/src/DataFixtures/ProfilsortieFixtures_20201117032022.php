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
        for ($i = 0; $i < 7; $i++)) {
            $profilsortie = new Profilsortie();
            $profilsortie->setLibelle($profilsortie[])
                ->setArchivage(0);
            $tabEntity[] = $profilsortie;
            $manager->persist($profilsortie);
        }
        $manager->flush();
    }
}
