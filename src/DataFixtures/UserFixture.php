<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixture extends Fixture
{
    const STATUS_REF = 'UserNum';
    private $passwordEncoder;
    public function __construct(UserPasswordHasherInterface  $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

         $user = new User();
         $user->setRoles(['ROLE_ADMIN']);
         $user->setUsername('admin');
         $user->setPassword($this->passwordEncoder->hashPassword($user, 'secret'));

         $manager->persist($user);

         $agent = new User();
         $agent->setRoles(['ROLE_AGENT']);
         $agent->setUsername('agent');
         $agent->setPassword($this->passwordEncoder->hashPassword($agent, 'secret'));

         $manager->persist($agent);

         for ($i = 0; $i <= 10; $i++) {
             $client = new User();
             $client->setRoles(['ROLE_CLIENT']);
             $client->setUsername("client$i");
             $client->setPassword($this->passwordEncoder->hashPassword($client, 'secret'));
             $this->addReference(self::STATUS_REF."$i", $client);
             $manager->persist($client);
         }
        $manager->flush();
    }
}
