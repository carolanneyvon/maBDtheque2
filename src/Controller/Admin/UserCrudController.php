<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('User')
            ->setSearchFields(['id', 'email', 'roles', 'nom', 'prenom', 'adresse', 'telephone']);
    }

    public function configureFields(string $pageName): iterable
    {
        $email = TextField::new('email');
        $password = TextField::new('password');
        $nom = TextField::new('nom');
        $prenom = TextField::new('prenom');
        $adresse = TextField::new('adresse');
        $telephone = TextField::new('telephone');
        $dateNaissance = DateField::new('date_naissance');
        $id = IntegerField::new('id', 'ID');
        $roles = ArrayField::new('roles');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $nom, $prenom,$roles, $adresse, $telephone, $dateNaissance];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $email, $roles, $password, $nom, $prenom, $adresse, $telephone, $dateNaissance];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$email, $password, $nom,$roles, $prenom, $adresse, $telephone, $dateNaissance];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$email, $password, $nom, $prenom, $roles, $adresse, $telephone, $dateNaissance];
        }
    }
}
