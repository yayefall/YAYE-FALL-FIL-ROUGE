<?php

namespace App\DataFixtures;

use App\Entity\Profils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $times = 4;
        $profiles = ["ADMIN", "FORMATEUR", "APPRENANT", "CM"];
        for ($i = 0; $i < $times; $i++) {
            $profile = new Profils();
            $profile->setLibelle($profiles[$i]);
            $profile->setArchivage(0);
            $this->addReference($i, $profile);
            $manager->persist($profile);
        }

        $manager->flush();
    }



            /*$times = 4;
            $profiles = ["ADMIN", "FORMATEUR", "APPRENANT", "CM"];
            foreach ($rofils as $prof) {
            $profile = new Profils();
            $profile->setLibelle($prof);
            $profile->setArchivage(0);
            $this->addReference( $prof);
            $manager->persist($profile);
            }

            $manager->flush();
            }*/


}
