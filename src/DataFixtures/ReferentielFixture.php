<?php

namespace App\DataFixtures;


use App\Entity\Referentiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ReferentielFixture extends Fixture
{

    public static function getReferenceKey($i)
    {
        return sprintf('referentiel_%s', $i);
    }

    public function load(ObjectManager $manager)
    {


        //On ajoute les référentiels

        $faker = Factory::create('fr_FR');


        for ($i=1;$i<= 10;$i++){
            $referentiel = new Referentiel();
        $referentiel->setLibelle("nous somme des referentiels_".$i)
            ->setPresentation("$faker->text")
            ->setProgramme($faker->text)
            ->setCritereEvaluation($faker->text)
            ->setCritereAdmission($faker->text)
            ->setArchivage(0);
            $this->addReference(self::getReferenceKey($i),$referentiel);

        $manager->persist($referentiel);
     }
        $manager->flush();
    }
}