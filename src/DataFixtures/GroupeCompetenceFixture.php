<?php

namespace App\DataFixtures;

use App\Entity\GroupeCompetence;
use App\Repository\TagRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class GroupeCompetenceFixture extends Fixture implements  DependentFixtureInterface
{

    private $TagRepository;

    public function __construct(TagRepository $TagRepository){

        $this->TagRepository=$TagRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $tabtag= $this->TagRepository->findAll();
        foreach ($tabtag as $tag){
            $tableauTag[]=$tag;
        }
        for ($a=1; $a<=13; $a++){

            $competence[]=$this->getReference(CompetenceFixture::getReferenceKey($a));

        }
        for ($f=1; $f<10; $f++){
            $referentiel[]=$this->getReference(ReferentielFixture::getReferenceKey($f %10));

        }
        for ($b=1;$b<=4;$b++){
            $groupecompetence= new GroupeCompetence();
            $groupecompetence->setLibelle($faker->text)
                ->setDescriptif($faker->text)
                ->setArchivage(0);
                for ($c=1;$c<=4;$c++){
                    $groupecompetence->addCompetence($faker->unique(true)->randomElement($competence));
                }
                for ($d=1;$d<4;$d++){
                    $groupecompetence->addTag($faker->unique(true)->randomElement($tableauTag));

                }
            for ($c=1;$c<=2;$c++){

                $groupecompetence->addReferentiel($faker->unique(true)->randomElement($referentiel));
                $manager->persist($groupecompetence);
            }


            $manager->flush();


        }

    }

    public function getDependencies()
    {
        return array(
            CompetenceFixture::class,
            ReferentielFixture::class

    );
    }
}

        //On ajouter les fixtures des competences
       /*$competenceTable = [
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
        }*/


