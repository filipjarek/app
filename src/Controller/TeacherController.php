<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    #[Route('/teachers', name: 'show_teachers', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $users = $paginator->paginate(
            $userRepository->findUsersOfRoles(['ROLE_TEACHER']),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('teacher/show.html.twig', [  
            'users' => $users
        ]);
    }
}
