<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Student;
use App\Entity\Teacher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');

        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new() 
            ->setTitle('App');

           
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Students', 'fas fa-list', Student::class);
        yield MenuItem::linkToCrud('Teachers', 'fas fa-list', Teacher::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);
    }
}
