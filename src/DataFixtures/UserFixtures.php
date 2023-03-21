<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $user = new User();
        $user->setFirstname('David')
            ->setLastname('Joe')
            ->setUsername('admin')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword(
                $this->hasher->hashPassword($user, 'password')
            );

        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())
                ->SetUsername($this->faker->userName())
                ->setRoles(['ROLE_USER'])
                ->setPassword(
                    $this->hasher->hashPassword($user, 'password')
                );

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}