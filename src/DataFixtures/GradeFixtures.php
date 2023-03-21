<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Grade;

class GradeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $grade = new Grade();
        $grade->setName('1');
        $manager->persist($grade);

        $grade = new Grade();
        $grade->setName('2');
        $manager->persist($grade);

        $grade = new Grade();
        $grade->setName('3');
        $manager->persist($grade);

        $grade = new Grade();
        $grade->setName('4');
        $manager->persist($grade);

        $grade = new Grade();
        $grade->setName('5');
        $manager->persist($grade);

        $grade = new Grade();
        $grade->setName('6');
        $manager->persist($grade);
        
        $manager->flush();
    }
}