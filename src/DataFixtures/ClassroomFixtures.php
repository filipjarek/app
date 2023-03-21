<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Classroom;

class ClassroomFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $classroom = new Classroom();
        $classroom->setName('4');
        $manager->persist($classroom);

        $classroom = new Classroom();
        $classroom->setName('5');
        $manager->persist($classroom);

        $classroom = new Classroom();
        $classroom->setName('6');
        $manager->persist($classroom);

        $classroom = new Classroom();
        $classroom->setName('7');
        $manager->persist($classroom);

        $classroom = new Classroom();
        $classroom->setName('8');
        $manager->persist($classroom);
        
        $manager->flush();
    }
}