<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StudentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('fullname');
        $class = ['4', '5', '6', '7', '8'];
        yield ChoiceField::new( 'class' )
            ->setChoices( array_combine( $class, $class ) )
            ->renderAsBadges();
    }
    
}
