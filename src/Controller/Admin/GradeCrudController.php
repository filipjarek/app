<?php

namespace App\Controller\Admin;

use App\Entity\Grade;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GradeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Grade::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Gradebook Grade')
            ->setEntityLabelInPlural('Gradebook Grades');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
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
