<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GenreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Genre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Genre')
            ->setEntityLabelInPlural('Genre')
            ->setSearchFields(['id', 'name']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $produits = AssociationField::new('produits');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $produits];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $produits];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $produits];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $produits];
        }
    }
}
