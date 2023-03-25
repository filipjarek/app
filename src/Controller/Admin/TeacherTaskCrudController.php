<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\TeacherTask;
use Doctrine\ORM\QueryBuilder;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TeacherTaskCrudController extends AbstractCrudController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return TeacherTask::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user', 'User'))
            ->add(EntityFilter::new('subject', 'Subject'));
    }

    public function configureFields(string $pageName): iterable
    {
        $userRepository = $this->em->getRepository(User::class);
            
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('user', 'ID | Teacher')->setFormTypeOption(
            'query_builder', function (UserRepository  $userRepository){
                return $userRepository->createQueryBuilder('u')
                    ->andWhere('u.roles LIKE :role')
                    ->setParameter('role', '%"ROLE_TEACHER"%');
                 }
            );
        yield AssociationField::new('subject');
        yield AssociationField::new('classroom');
        yield DateTimeField::new('createdAt')
            ->hideONForm()
            ->setTimezone('Europe/Warsaw')
            ->setFormat('short', 'medium');
        yield DateTimeField::new('updatedAt')
            ->hideONForm()
            ->setTimezone('Europe/Warsaw')
            ->setFormat('short', 'medium');
    }
}
