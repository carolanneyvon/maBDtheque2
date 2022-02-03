<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('date')
            //->add('total')
            /*
            ->add('adresse',EntityType::class,[
                'label' =>'Adresse de livraison',
                'class'=>User::class,
                'choice_label' => 'adresse'
            ]
            )*/
            ->add('submit', SubmitType::class ,['label'=>"Confirmer ma commande",'attr'=>[
                'class' => " btn btn-lg btn-warning "
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
