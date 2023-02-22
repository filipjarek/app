<?php

namespace App\Controller\Admin;

use App\Entity\Classroom;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClassroomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classroom::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->setDisabled();
        yield TextField::new('name');
        yield AssociationField::new( 'subject' );
    }
}
