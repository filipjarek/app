<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/students', name: 'app_student', methods: ['GET'])]
    public function showStudents(EntityManagerInterface $em, Environment $twig, StudentRepository $studentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $studentRepository = $em->getRepository(Student::class);
        $allStudentsQuery = $studentRepository->findAll();

        $students = $paginator->paginate(
            $allStudentsQuery,
            $request->query->getInt('page', 1),
            5
        );
        return new Response($twig->render('student/index.html.twig', [
            'students' => $studentRepository->findBy([], ['lastname' => 'ASC', 'firstname' => 'ASC']),
            'students' => $students
        ]));
    }
}
