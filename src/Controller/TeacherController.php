<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(Environment $twig, TeacherRepository $teacherRepository): Response
    {
        return new Response($twig->render('teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]));
    }       
   
}