<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(Environment $twig, StudentRepository $studentRepository): Response
    {
        return new Response($twig->render('student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]));
    }     
}
