<?php

namespace App\Controller\Admin;

use App\Entity\Teacher;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TeacherCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Teacher::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('fullname');
        $school_subject = ['mathematics', 'history', 'computer science ', 'physics', 'history'];
        yield ChoiceField::new( 'school_subject' )
            ->setChoices( array_combine( $school_subject, $school_subject ) )
            ->renderAsBadges();
            
    }
}
