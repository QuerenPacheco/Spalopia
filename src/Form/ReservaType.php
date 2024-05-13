<?php

namespace App\Form;

use App\Entity\ServicioSpa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('email', EmailType::class)
            ->add('servicio', EntityType::class, [
                'class' => ServicioSpa::class,
                'choice_label' => 'nombre',
                'choice_value' => 'id',
                'choice_attr' => function($choice) {
                    $precio = $choice->getPrecio();
                    return ['data-precio' => $precio];
                }, 
            ])
            ->add('precio', null, [
                'disabled' => true,
            ])


            ->add('Reservar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'id' => 'formularioReservas',
        ]);
    }
}