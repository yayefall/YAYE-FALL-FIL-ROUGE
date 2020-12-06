<?php

namespace App\DataFixtures;


use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class GroupeFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {

        // TODO: Implement load() method.
        $faker = Factory::create('fr_FR');

    }


}
