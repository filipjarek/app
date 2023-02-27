<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Classroom;
use App\Entity\Grade;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Users
        $user = new User();
        $user->setFirstname('David')
            ->setLastname('Joe')
            ->SetUsername('admin')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $user,
                    "password"
                )
            );

        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())
                ->SetUsername($this->faker->userName())
                ->setRoles(['ROLE_USER'])
                ->setPassword(
                    $this->userPasswordHasherInterface->hashPassword(
                        $user,
                        "password"
                    )
                );

            $manager->persist($user);
        }

        // Students
        for ($i = 0; $i < 10; $i++) {
            $student = new Student();
            $student->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName());

            $manager->persist($student);
        }

        // Subjects
        $subject = new Subject();
        $subject->setName('geography');
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('math');
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('history');
        $manager->persist($subject);

        // Classrooms
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

        // Grades
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
