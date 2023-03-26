<?php

namespace App\DataFixtures;

use App\Entity\Teachertask;
use App\Repository\UserRepository;
use App\Repository\SubjectRepository;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TeachertaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private ClassroomRepository $classroomRepository,
        private SubjectRepository $subjectRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findUsersOfRoles(['ROLE_TEACHER']);
        $classrooms = $this->classroomRepository->findAll();
        $subjects = $this->subjectRepository->findAll();
       
        $teachertasks = [];
        for ($i = 0; $i < 2; $i++) {
            $teachertask = new Teachertask();
            $teachertask->setUser($users[mt_rand(0, count($users) - 1)])
                ->setSubject($subjects[mt_rand(0, count($subjects) - 1)])
                ->setClassroom($classrooms[mt_rand(0, count($classrooms) - 1)]);

            $teachertasks[] = $teachertask;
            $manager->persist($teachertask);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SubjectFixtures::class,
            ClassroomFixtures::class
        ];
    }
}