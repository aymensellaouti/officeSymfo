<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TicketFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr');
        for($i = 1; $i <= 100; $i++){
            $ticket = new Ticket();
            $ticket->setDesignation("ticket$i")
                   ->setDescription($faker->realText(50))
                   ->addDepartement($this->getReference(DepartementFixture::DEPARTEMENT_REF.$faker->numberBetween(1,20)))
                   ->setStatus($this->getReference(StatusFixture::STATUS_REF.$faker->numberBetween(1,3)))
            ;
            $manager->persist($ticket);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DepartementFixture::class,
            StatusFixture::class
        ];
    }
}
