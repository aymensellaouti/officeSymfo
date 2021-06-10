<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DepartementFixture extends Fixture
{
    const DEPARTEMENT_REF = 'departemantNum';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr');
        for($i = 1; $i <= 20; $i++){
            $departement = new Departement();
            $departement->setDesignation($faker->company);
            $this->addReference(self::DEPARTEMENT_REF.$i, $departement);
            $manager->persist($departement);
        }

        $manager->flush();
    }
}
