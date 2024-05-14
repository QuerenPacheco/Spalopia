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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre_cliente', TextType::class, [
                'label' => 'Nombre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingresa tu nombre.',
                    ]),
                ],
            ])
            ->add('email_cliente', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingresa tu correo electrónico.',
                    ]),
                ],
            ])
            ->add('servicio', EntityType::class, [
                'class' => ServicioSpa::class,
                'choice_label' => 'nombre',
                'choice_value' => 'id',
                'choice_attr' => function($choice) {
                    $precio = $choice->getPrecio();
                    return ['data-precio' => $precio];
                }, 
            ])

            ->add('fecha', DateType::class, [
                'label' => 'Fecha',
                'widget' => 'single_text'
                ,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingresa una fecha.',
                    ]),
                ],
                
                
            ])
            ->add('precio', null, [
                'disabled' => true,
            ])

            ->add('hora', HiddenType::class)

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