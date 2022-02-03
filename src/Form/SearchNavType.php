<?php

namespace App\Form;

use App\Classe\SearchNav;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchNavType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('string', TextType::class, [
        'label' => false,
        'required' => false,
        'attr' => [
          'placeholder' => 'Rechercher sur MaBDthèque...',
          'class' => 'me-2',
        ]
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Rechercher',
        'attr' => ['class' => 'btn btn-warning']
      ])->setAction('/');
  }


  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => SearchNav::class,
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
