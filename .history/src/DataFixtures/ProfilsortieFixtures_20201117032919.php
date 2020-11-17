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
        
        //profilsortie
        for ($i = 1; $i < 7; $i++) {
            $profilsorti = new Profilsortie();
            $profilsorti->setLibelle($profilsortie[$i])
                        ->setArchivage(0);
            $this->addReference($i, $profilsorti);
            
            $manager->persist($profilsorti);
        }
        $manager->flush();
    }
}
