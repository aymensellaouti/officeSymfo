<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixture extends Fixture
{
    const STATUS_REF = 'statusNum';
    public function load(ObjectManager $manager)
    {
         $status = new Status();
         $status->setDescription('En cours')->setClasse('primary');
         $this->addReference(self::STATUS_REF."1", $status);
         $manager->persist($status);
         $status1 = new Status();
         $status1->setDescription('Annulé')->setClasse('danger');
         $this->addReference(self::STATUS_REF."2", $status1);
         $manager->persist($status1);
         $status2 = new Status();
         $status2->setDescription('Affecté')->setClasse('success');
         $this->addReference(self::STATUS_REF."3", $status2);
         $manager->persist($status2);

        $manager->flush();
    }
}
