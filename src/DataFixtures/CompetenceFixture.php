<?php

namespace App\DataFixtures;


use App\Entity\Competence;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class  CompetenceFixture extends Fixture
{


    public static function getReferenceKey($i)
    {
        return sprintf('competence_%s', $i);

    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($b=1;$b<=13;$b++){
            $competence = new Competence();
            $competence->setLibelle('libelle_'.$b)
                ->setDescriptif($faker->text)
                ->setArchivage(0);
             $this->addReference(self::getReferenceKey($b),$competence);
            $manager->persist($competence);

            //On ajoute les niveaux en fonctions des compétences
            for ($i = 1; $i <= 3; $i++) {
                $niveau = new Niveau();
                $niveau->setLibelle('Niveau '. $i)
                    ->setGroupeDaction($faker->text)
                    ->setCritereEvaluation($faker->text)
                    ->setArchivage(0);
                $manager->persist($niveau);
                $competence->addNiveau($niveau);
            }

        }
        $manager->flush();
    }

}