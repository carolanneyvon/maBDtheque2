<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produit')
            ->setSearchFields(['id', 'titre', 'auteur', 'prix', 'isbn', 'description', 'editeur', 'disponibilite', 'nombre_de_pages', 'image']);
    }

    public function configureFields(string $pageName): iterable
    {
        $titre = TextField::new('titre');
        $auteur = TextField::new('auteur');
        $prix = MoneyField::new('prix')->setCurrency('EUR');
        $isbn = TextField::new('isbn');
        $description = TextareaField::new('description');
        $coupCoeur = BooleanField::new('isBest');
        $nosConseils = BooleanField::new('conseil');
        $editeur = TextField::new('editeur');
        $disponibilite = TextField::new('disponibilite');
        $nombreDePages = IntegerField::new('nombre_de_pages');
        $image = ImageField::new('image')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(true);
        $categorie = AssociationField::new('categorie');
        $genre = AssociationField::new('genre');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$image, $titre, $auteur, $prix, $coupCoeur, $nosConseils, $isbn, $editeur, $disponibilite];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $titre, $auteur, $prix, $isbn, $description, $coupCoeur, $nosConseils, $editeur, $disponibilite, $nombreDePages, $image, $categorie, $genre];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$titre, $auteur, $prix, $isbn, $description, $coupCoeur, $nosConseils, $editeur, $disponibilite, $nombreDePages, $image, $categorie, $genre];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$titre, $auteur, $prix, $isbn, $description, $coupCoeur, $nosConseils, $editeur, $disponibilite, $nombreDePages, $image, $categorie, $genre];
        }
    }
}
