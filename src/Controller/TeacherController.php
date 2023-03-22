<?php

namespace App\Controller;

use App\Repository\TeacherTaskRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TeacherController extends AbstractController
{
    #[Route('/teachers', name: 'show_teachers', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, TeacherTaskRepository $teachertaskRepository, PaginatorInterface $paginator): Response
    {
        $teachertasks = $paginator->paginate(
            $teachertaskRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('teacher/show.html.twig', [  
            'teachertasks' => $teachertasks
        ]);
    }
}
