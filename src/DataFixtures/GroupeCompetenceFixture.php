<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Entity\Niveau;
use App\Entity\Referentiel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class GroupeCompetenceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        ///On ajouter les fixtures des competences
        $competenceTable = [
            "Créer une base de données", "Développer les composants d'accès d'une base de donnée",
            "Développer les composants d'ApiPlatform"
        ];

        //On ajoute les référentiels

        $referentiel = new Referentiel();

        $referentiel->setLibelle("nous somme des referentiels")
            ->setPresentation("$faker->text")
            ->setProgramme($faker->text)
            ->setCritereEvaluation($faker->text)
            ->setCritereAdmission($faker->text)
            ->setArchivage(0);

        $groupeCompetence = new GroupeCompetence();

        foreach ($competenceTable as $competenceLibelle) {

            $competence = new Competence();
            $competence->setLibelle($competenceLibelle)
                ->setDescriptif($faker->text)
                ->setArchivage(0);


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

            $manager->persist($competence);
            $referentiel->addGroupeCompetence($groupeCompetence);


            $manager->persist($referentiel);

            $tabgroupecompetence = [
                'Créer une base de données ',
                'Developper une application durable',
                'Développer les composants d’accès aux données'
            ];
            foreach ($tabgroupecompetence as $libelle) {
                //On génère un groupe de compétence
                $groupeCompetence->setLibelle($libelle)
                    ->setDescriptif($faker->text)
                    ->addCompetence($competence)
                    ->setArchivage(0);
                $manager->persist($groupeCompetence);
            }
            $manager->flush();
        }


    }
}