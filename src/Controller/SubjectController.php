<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Student;
use App\Entity\TeacherTask;
use App\Repository\TaskRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TeacherTaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubjectController extends AbstractController
{
    public function __construct(
        protected TeacherTaskRepository $teachertaskRepository,
        protected StudentRepository $studentRepository,
        protected TaskRepository $taskRepository,
    ) {
    }

    #[Route('/subject', name: 'show_subjects', methods: ['GET'])]
    public function showSubjects(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, TeacherTaskRepository $teachertaskRepository): Response
    {
        $teachertasks = $paginator->paginate(
            $teachertaskRepository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            5
        );  
        return $this->render('subject/index.html.twig', [
            'teachertasks' => $teachertasks
        ]);
    }

    #[Route('/subject/class/{id}', name: 'show_class', methods: ['GET'])]
    public function showClassroom($id, Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $teachertasks = $this->teachertaskRepository->find($id);
        $studentRepository = $em->getRepository(Student::class);
        $allStudentsQuery = $studentRepository->findBy(['classroom' => $id]);
        $tasks = $this->taskRepository->findBy(['student' => $id]);

        $students = $paginator->paginate(
            $allStudentsQuery,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('subject/showclass.html.twig', [
            'teachertasks' => $teachertasks,
            'students' => $studentRepository,
            'students' => $students,
            'tasks' => $tasks
        ]);
    }

    #[Route('/subject/class/student/{id}', name: 'show_student', methods: ['GET'])]
    public function showStudent($id, Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $student = $this->studentRepository->find($id);
        $taskRepository = $em->getRepository(Task::class);
        $alltaskRepository = $taskRepository->findBy(['student' => $id]);

        $tasks = $paginator->paginate(
            $alltaskRepository,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('subject/showstudent.html.twig', [
            'student' => $student,
            'tasks' => $taskRepository,
            'tasks' => $tasks
        ]);
    }
}
