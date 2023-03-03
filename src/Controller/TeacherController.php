<?php

namespace App\Controller;

use App\Entity\Task;
use Twig\Environment;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TeacherTaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    private $teachertaskRepository;
    private $studentRepository;
    private $taskRepository;
    private $em;

    public function __construct(
        TeacherTaskRepository $teachertaskRepository,
        StudentRepository $studentRepository,
        TaskRepository $taskRepository,
        EntityManagerInterface $em
    ) {
        $this->teachertaskRepository = $teachertaskRepository;
        $this->studentRepository = $studentRepository;
        $this->taskRepository = $taskRepository;
        $this->em = $em;
    }

    #[Route('/teachers', name: 'show_teachers', methods: ['GET'])]
    public function index(Environment $twig, TeacherTaskRepository $teachertaskRepository): Response
    {
        return new Response($twig->render('teacher/show.html.twig', [
            'teachertasks' => $teachertaskRepository->findAll()
        ]));
    }

    #[Route('/subject', name: 'show_subjects', methods: ['GET'])]
    public function showSubjects(Environment $twig, TeacherTaskRepository $teachertaskRepository,): Response
    {
        return new Response($twig->render('teacher/index.html.twig', [
            'teachertasks' => $teachertaskRepository->findBy(['user' => $this->getUser()])
        ]));
    }

    #[Route('/subject/class/{id}', name: 'show_class', methods: ['GET'])]
    public function showClassroom($id): Response
    {
        $teachertasks = $this->teachertaskRepository->find($id);
        $students = $this->studentRepository->findBy(['classroom' => $id]);
        $tasks = $this->taskRepository->findBy(['student' => $id]);

        return $this->render('teacher/showclass.html.twig', [
            'teachertasks' => $teachertasks,
            'students' => $students,
            'tasks' => $tasks
        ]);
    }

    #[Route('/subject/class/student/{id}', name: 'show_student', methods: ['GET'])]
    public function showStudent($id): Response
    {
        $student = $this->studentRepository->find($id);
        $tasks = $this->taskRepository->findBy(['student' => $id]);

        return $this->render('teacher/showstudent.html.twig', [
            'student' => $student,
            'tasks' => $tasks
        ]);
    }

    #[Route('/subject/class/student/grade/delete/{id}', name: 'delete_grade', methods: ['GET', 'DELETE'])]
    public function delete($id): Response
    {
        $task = $this->taskRepository->find($id);
        $this->em->remove($task);
        $this->em->flush();

        $this->addFlash(
            'success',
            'Successfully deleted grade'
        );

        return $this->redirectToRoute('show_subjects');
    }

    #[Route('/subject/class/student/{id}/grade/add', name: 'add_grade', methods: ['GET'])]

    public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $student = $this->studentRepository->find($id);
        $teachertask = $this->teachertaskRepository->find($id);
        $task = new Task();
        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Successfully added grade"
            );

            return $this->redirectToRoute('show_subjects');
        }

        return $this->render('teacher/creategrade.html.twig', [
            'student' => $student,
            'teachertask' => $teachertask,
            'form' => $form->createView()
        ]);
    }

    #[Route('/subject/class/student/grade/edit/{id}', name: 'edit_grade', methods: ['GET', 'POST'])]
    public function edit(Task $task, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Successfully edited grade"
            );

            return $this->redirectToRoute('show_subjects');
        }

        return $this->render('/teacher/editgrade.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
