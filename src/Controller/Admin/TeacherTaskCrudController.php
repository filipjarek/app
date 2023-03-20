<?php

namespace App\Controller\Admin;

use App\Entity\TeacherTask;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TeacherTaskCrudController extends AbstractCrudController
{
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
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('user');
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
