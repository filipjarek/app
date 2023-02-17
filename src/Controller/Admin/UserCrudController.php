<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class UserCrudController extends AbstractCrudController
{
   
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields( string $pageName ): iterable {
        
        yield IdField::new('id')->setDisabled();
        yield TextField::new('username');
        yield TextField::new('password')->setFormType(PasswordType::class);
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        yield ChoiceField::new( 'roles' )
            ->setChoices( array_combine( $roles, $roles ) )
            ->renderAsBadges()
            ->allowMultipleChoices();
        
    }
        
}
