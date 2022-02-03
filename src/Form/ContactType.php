<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
 public function buildForm(FormBuilderInterface $builder, array $options)
 {
  $builder
   ->add('nom', TextType::class, [
    'label' => 'Votre nom ',
    'attr' => [
     'placeholder' => 'Votre nom',
    ]
   ])
   ->add('email', EmailType::class, [
    'label' => 'Votre e-mail ',
    'attr' => [
     'placeholder' => 'Votre e-mail',
    ]
   ])
   ->add('objet', TextType::class, [
    'label' => 'Objet ',
    'attr' => [
     'placeholder' => 'Objet ',
    ]
   ])
   ->add('textarea', TextareaType::class, [
    'label' => 'Votre message ',
    'attr' => [
     'placeholder' => 'Votre message  ',
    ]
   ])
   ->add('submit', SubmitType::class, [
    'label' => 'Envoyer ',
    'attr' => ['class' => 'btn-block btn-warning m-2']
   ]);
 }

 public function configureOptions(OptionsResolver $resolver)
 {
   
 }

 // url vide apres la recherche
 public function getBlockPrefix()
 {
  return '';
 }
}
