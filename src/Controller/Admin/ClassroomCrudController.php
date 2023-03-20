<?php

namespace App\Controller\Admin;

use App\Entity\Classroom;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClassroomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classroom::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Gradebook Classroom')
            ->setEntityLabelInPlural('Gradebook Classrooms');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield AssociationField::new('subject');
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
