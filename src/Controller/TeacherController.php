<?php

namespace App\Controller;


use Twig\Environment;
use App\Repository\StudentRepository;
use App\Repository\TeacherTaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    #[Route('/teachers', name: 'show_teachers')]
    public function shoStudents(Environment $twig, StudentRepository $studentRepository): Response
    {
        return new Response($twig->render('teacher/show.html.twig', [
            'students' => $studentRepository->findAll(),
        ]));
    }    

    #[Route('/subjects', name: 'app_teacher')]
    public function index(Environment $twig, TeacherTaskRepository $teachertaskRepository, ): Response
    {
        
        return new Response($twig->render('teacher/index.html.twig', [
            'teachertasks' => $teachertaskRepository->findBy(['user' => $this->getUser()])
        ]));
    }       

    #[Route('/class/{id}', name: 'app_student2')]
    public function showClass(Environment $twig, StudentRepository $studentRepository): Response
    {
        return new Response($twig->render('teacher/student.html.twig', [
            'students' => $studentRepository->findAll(),
        ]));
    } 
   
}