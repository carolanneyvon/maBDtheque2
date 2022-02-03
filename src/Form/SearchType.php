<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('stringFilter', TextType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Votre recherche',
          'class' => 'form-control-sm'
        ]
      ])
      ->add('categories', EntityType::class, [
        'label' => false,
        'required' => false,
        'class' => Categorie::class,
        'multiple' => true, //selectionner plusieurs parametres
        'expanded' => true // vu en checkbox pour selectionner plusieurs valeurs
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Filtrer',
        'attr' => ['class' => 'btn-block btn-warning']
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Search::class,
      'method' => 'GET',
      'crsf_protecttion' => false,
    ]);
  }

  // url vide apres la recherche
  public function getBlockPrefix()
  {
    return '';
  }
}
