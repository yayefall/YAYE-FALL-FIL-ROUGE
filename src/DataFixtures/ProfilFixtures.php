<?php

namespace App\DataFixtures;

use App\Entity\Profils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $profiles = ["ADMIN", "FORMATEUR", "APPRENANT", "CM"];
        for ($i = 0; $i < 4; $i++) {
            $profile = new Profils();
            $profile->setLibelle($profiles[$i]);
            $profile->setArchivage(0);
            $this->addReference($i, $profile);
            $manager->persist($profile);
        }

        $manager->flush();
    }
}
