<?php

namespace App\DataFixtures;

use App\Entity\GroupeTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GroupeTagFixture extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');



      $tab=["Développement Mobile","Systèmes et réseaux",
          "Objets connectés","crer une base de donnee",
          "creer une applictaion mobile"];

        for ($i=1;$i<count($tab);$i++){

            $groupetag=new GroupeTag();
            $groupetag->setLibelle($tab[$i])
                ->setArchivage(0);

           // $this->addReference(self::getReferenceKey($i),$groupetag);
            for ($j=1;$j<=2;$j++){

                for ($a=0;$a<8;$a++){

                    $groupetag->addTag($this->getReference(TagFixture::getReferenceKey($a)));

                }


            }
            $manager->persist($groupetag);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TagFixture::class,

        );
    }

}