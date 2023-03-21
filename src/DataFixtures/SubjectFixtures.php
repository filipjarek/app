<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subject;
use Faker\Factory;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $subject = new Subject();
        $subject->setName('history');
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('math');
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('biology');
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('physics');
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('geography');
        $manager->persist($subject);
        
        $manager->flush();
    }
}