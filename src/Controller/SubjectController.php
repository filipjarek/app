<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Subject;
use App\Entity\Student;
use App\Entity\TeacherTask;
use App\Repository\TaskRepository;
use App\Repository\StudentRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TeacherTaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubjectController extends AbstractController
{
    public function __construct(
        protected TeacherTaskRepository $teachertaskRepository,
        protected StudentRepository $studentRepository,
        protected TaskRepository $taskRepository,
        protected SubjectRepository $subjectRepository,
    ) {
    }

    #[Route('/subject', name: 'show_subjects', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
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

    #[Route('/subject/{subject_id}/class/{id}', name: 'show_class', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    #[Entity('task', expr: 'repository.find(subject_id)')]
    public function showClassroom($id, $subject_id, Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        if (!$teachertasks = $this->teachertaskRepository->findOneById($id)) {
            throw new NotFoundHttpException();
        }
        
        $subject = $this->subjectRepository->find($subject_id);
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
            'subject' => $subject,
            'tasks' => $tasks
        ]);
    }

    #[Route('/subject/{subject_id}/class/{classroom_id}/student/{id}', name: 'show_student', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    #[Entity('task', expr: 'repository.find(subject_id)')]
    public function showStudent($id, $subject_id, $classroom_id, Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        if (!$student = $this->studentRepository->find($id)) {
            throw new NotFoundHttpException();
        }
        
        $subject = $this->subjectRepository->find($subject_id);
        $taskRepository = $em->getRepository(Task::class);
        $alltaskRepository = $taskRepository->findBy(['student' => $id]);

        $tasks = $paginator->paginate(
            $alltaskRepository,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('subject/showstudent.html.twig', [
            'student' => $student,
            'subject' => $subject,
            'tasks' => $taskRepository,
            'tasks' => $tasks
        ]);
    }
}
