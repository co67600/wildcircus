<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Tournee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add( 'tournees', EntityType::class, [
                'class' => Tournee::class,
                'choice_label' => 'ville',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('Adultes')
            ->add('enfants')



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
