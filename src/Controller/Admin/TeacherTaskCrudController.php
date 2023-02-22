<?php

namespace App\Controller\Admin;

use App\Entity\TeacherTask;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TeacherTaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeacherTask::class;
       
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->setDisabled();
        yield AssociationField::new('user');
        yield AssociationField::new('subject');
        yield AssociationField::new('classroom');
    }
}
