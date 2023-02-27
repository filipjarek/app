<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Student;
use App\Entity\Classroom;
use App\Entity\Subject;
use App\Entity\TeacherTask;
use App\Entity\Task;
use App\Entity\Grade;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
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
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Students', 'fas fa-user-graduate', Student::class);
        yield MenuItem::linkToCrud('Classrooms', 'fa-solid fa-chalkboard-user', Classroom::class);
        yield MenuItem::linkToCrud('Subjects', 'fas fa-book', Subject::class);
        yield MenuItem::linkToCrud('TeacherTasks', 'fa-solid fa-clipboard', TeacherTask::class);
        yield MenuItem::linkToCrud('Tasks', 'fa-solid fa-list-check', Task::class);
        yield MenuItem::linkToCrud('Grades', 'fa-solid fa-a', Grade::class);
    }
}
