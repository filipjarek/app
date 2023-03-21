<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Student;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StudentFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private ClassroomRepository $classroomRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $classrooms = $this->classroomRepository->findAll();

        foreach ($classrooms as $classroom) {
        for ($i = 0; $i < 10; $i++) {
            $student = new Student();
            $student->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName());

            $manager->persist($student);
            $classroom->addStudent($student);
        }
    }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ClassroomFixtures::class
        ];
    }
}