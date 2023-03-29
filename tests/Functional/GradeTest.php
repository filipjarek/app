<?php

namespace App\Tests\Functional;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Classroom;
use App\Repository\TaskRepository;
use App\Repository\StudentRepository;
use App\Repository\SubjectRepository;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GradeTest extends WebTestCase
{   
    public function testIfGradesPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        /** @var StudentRepository */
        $studentRepository = $em->getRepository(Student::class);

        /** @var Student */
        $student = $studentRepository->findOneBy([]);

        /** @var SubjectRepository */
        $subjectRepository = $em->getRepository(Subject::class);

        /** @var Subject */
        $subject = $subjectRepository->findOneBy([]);

        /** @var ClassroomRepository */
        $classroomRepository = $em->getRepository(Classroom::class);

        /** @var Classroom */
        $classroom = $classroomRepository->findOneBy([]);

        $client->loginUser($user);

        $client->request(
            Request::METHOD_GET, 
            $urlGeneratorInterface->generate('show_student', [
                'id'=>$student->getId(),
                'subject_id'=>$subject->getId(),
                'classroom_id'=>$classroom->getId()
            ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfCreateNewGradeWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        /** @var StudentRepository */
        $studentRepository = $em->getRepository(Student::class);

        /** @var Student */
        $student = $studentRepository->findOneBy([]);

        /** @var SubjectRepository */
        $subjectRepository = $em->getRepository(Subject::class);

        /** @var Subject */
        $subject = $subjectRepository->findOneBy([]);

        /** @var ClassroomRepository */
        $classroomRepository = $em->getRepository(Classroom::class);
       
        /** @var Classroom */
        $classroom = $classroomRepository->findOneBy([]);
      
        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET, 
            $urlGeneratorInterface->generate('add_grade', [
                'id'=>$student->getId(),
                'subject_id'=>$subject->getId(),
                'classroom_id'=>$classroom->getId()
            ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=task_form]')->form([
            'task_form[student]' => '2',
            'task_form[subject]' => '2',
            'task_form[grade]' => '2',
            'task_form[description]' => 'test',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
       
        $this->assertRouteSame('show_student');
        $this->assertSelectorTextContains('div.alert', 'Grade added successfully !');
       
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testIfEditGradeWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        /** @var StudentRepository */
        $studentRepository = $em->getRepository(Student::class);
       
        /** @var Student */
        $student = $studentRepository->findOneBy([]);

        /** @var SubjectRepository */
        $subjectRepository = $em->getRepository(Subject::class);
       
        /** @var Subject */
        $subject = $subjectRepository->findOneBy([]);

        /** @var ClassroomRepository */
        $classroomRepository = $em->getRepository(Classroom::class);

        /** @var Classroom */
        $classroom = $classroomRepository->findOneBy([]);

        /** @var TaskRepository */
        $taskRepository = $em->getRepository(Task::class);

        /** @var Task */
        $task = $taskRepository->findOneBy([]);
        
        $client->loginUser($user);

        $crawler =  $client->request(
            Request::METHOD_GET, 
            $urlGeneratorInterface->generate('edit_grade', [
                'id'=>$task->getId(),
                'student_id'=>$task->getStudent()->getId(),
                'subject_id'=>$task->getSubject()->getId(),
                'classroom_id'=>$classroom->getId()
            ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=task_form]')->form([
            'task_form[student]' => '2',
            'task_form[subject]' => '2',
            'task_form[grade]' => '4',
            'task_form[description]' => 'test22',
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('show_student');
        $this->assertSelectorTextContains('div.alert', 'Grade edited successfully !');
        
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testIfDeleteGradeWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->find(User::class, 1);

        /** @var StudentRepository  */
        $studentRepository = $em->getRepository(Student::class);

        /** @var Student */
        $student = $studentRepository->findOneBy([]);

        /** @var SubjectRepository */
        $subjectRepository = $em->getRepository(Subject::class);

        /** @var Subject */
        $subject = $subjectRepository->findOneBy([]);

        /** @var ClassroomRepository */
        $classroomRepository = $em->getRepository(Classroom::class);

        /** @var Classroom */
        $classroom = $classroomRepository->findOneBy([]);

        /** @var TaskRepository */
        $taskRepository = $em->getRepository(Task::class);
       
        /** @var Task */
        $task = $taskRepository->findOneBy([]);

        $client->loginUser($user);
        
        $crawler =  $client->request(
            Request::METHOD_GET, 
            $urlGeneratorInterface->generate('delete_grade', [
                'id'=>$task->getId(),
                'classroom_id'=>$classroom->getId()
            ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
    
        $this->assertRouteSame('show_student');
        $this->assertSelectorTextContains('div.alert', 'Grade deleted successfully !');
        
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }
}
