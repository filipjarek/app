<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/students', name: 'app_student', methods: ['GET'])]
    public function index(Request $request, StudentRepository $studentRepository, PaginatorInterface $paginator): Response
    {
        $students = $paginator->paginate(
            $studentRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('student/index.html.twig', [  
            'students' => $students
        ]);
    }
}
