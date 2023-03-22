<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GradeController extends AbstractController
{ 
    public function __construct(
        protected StudentRepository $studentRepository,
        protected TaskRepository $taskRepository,
        protected EntityManagerInterface $em
    ) {
    }

    #[Route('/subject/class/student/grade/delete/{id}', name: 'delete_grade', methods: ['GET', 'DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function deleteGrade($id, EntityManagerInterface $em): Response
    {
        $task = $this->taskRepository->find($id);
        $this->em->remove($task);
        $this->em->flush();

        return $this->redirectToRoute('show_subjects');
    }

    #[Route('/subject/class/student/{id}/grade/add', name: 'add_grade', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function newGrade(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $student = $this->studentRepository->find($id);
        $task = new Task();
        $task->setStudent($student);
        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $task = $form->getData();
          
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('show_subjects');
        }

        return $this->render('grade/creategrade.html.twig', [
            'student' => $student,
            'form' => $form->createView()
        ]);
    }

    #[Route('/subject/class/student/grade/edit/{id}', name: 'edit_grade', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function editGrade(Task $task, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('show_subjects');
        }

        return $this->render('/grade/editgrade.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
