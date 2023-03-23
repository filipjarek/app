<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use App\Repository\StudentRepository;
use App\Repository\SubjectRepository;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GradeController extends AbstractController
{ 
    public function __construct(
        protected StudentRepository $studentRepository,
        protected TaskRepository $taskRepository,
        protected SubjectRepository $subjectRepository,
        protected ClassroomRepository $classroomRepository,
        protected EntityManagerInterface $em
    ) {
    }

    #[Route('/subject/class/{classroom_id}/student/grade/delete/{id}', name: 'delete_grade', methods: ['GET', 'DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function deleteGrade($id, $classroom_id, EntityManagerInterface $em): Response
    {
        $classroom = $this->classroomRepository->find($classroom_id);
        $task = $this->taskRepository->find($id);
        $this->em->remove($task);
        $this->em->flush();

        $this->addFlash(
            'success',
            'Grade deleted successfully !'
        );

        return $this->redirectToRoute('show_student', [
            'id'=>$task->getStudent()->getId(),
            'subject_id'=>$task->getSubject()->getId(),
            'classroom_id'=>$classroom->getId()
        ]);
    }

    #[Route('/subject/{subject_id}/class/{classroom_id}/student/{id}/grade/add', name: 'add_grade', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    #[Entity('task', expr: 'repository.find(subject_id)')]
    public function newGrade(Request $request, EntityManagerInterface $entityManager, $id, $subject_id, $classroom_id): Response
    {   
        $student = $this->studentRepository->find($id);
        $subject = $this->subjectRepository->find($subject_id);
        $classroom = $this->classroomRepository->find($classroom_id);
        
        $task = new Task();
        $task->setStudent($student);
        $task->setSubject($subject);
       
        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $task = $form->getData();
          
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Grade added successfully !'
            );

            return $this->redirectToRoute('show_student', [
                'id'=>$student->getId(),
                'subject_id'=>$subject->getId(),
                'classroom_id'=>$classroom->getId()
            ]);
        }

        return $this->render('grade/creategrade.html.twig', [
            'student' => $student,
            'subject' => $subject,
            'form' => $form->createView()
        ]);
    }

    #[Route('/subject/{subject_id}/class/{classroom_id}/student/{student_id}/grade/edit/{id}', name: 'edit_grade', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    #[Entity('task', expr: 'repository.find(subject_id, student_id)')]
    public function editGrade($subject_id, $student_id, $classroom_id, Task $task, Request $request, EntityManagerInterface $entityManager): Response
    {   
        $student = $this->studentRepository->find($student_id);
        $subject = $this->subjectRepository->find($subject_id);
        $classroom = $this->classroomRepository->find($classroom_id);

        $form = $this->createForm(TaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Grade edited successfully !'
            );

            return $this->redirectToRoute('show_student', [
                'id'=>$task->getStudent()->getId(),
                'subject_id'=>$task->getSubject()->getId(),
                'classroom_id'=>$classroom->getId()
            ]);
        }

        return $this->render('/grade/editgrade.html.twig', [
            'task' => $task,
            'subject' => $subject,
            'student' => $student,
            'form' => $form->createView()
        ]);
    }
}
