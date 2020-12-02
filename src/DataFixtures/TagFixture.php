<?php

namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class TagFixture extends Fixture
{


    public static function getReferenceKey($i){
        return sprintf('tag_%s',$i);

    }


public function load(ObjectManager $manager)
{
        $faker = Factory::create('fr_FR');

        $tab=["HTML","php","css","angular","json","java","CID","AKS"];
        for ($i=0;$i<count($tab);$i++){

            $tag=new Tag();
            $tag->setLibelle($tab[$i])
                ->setDescriptif($faker->text)
                ->setArchivage(0);
            $this->addReference(self::getReferenceKey($i),$tag);
            $manager->persist($tag);

           }
        $manager->flush();
        }


}