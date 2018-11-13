<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class ChangePasswordType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'El password de confirmación no coincide.',
                'options' => [
                    'attr' => [
                        'class' => 'password-field form-control'
                    ]
                ],
                'required' => true,
                'first_options'  => ['label' => 'Nuevo password'],
                'second_options' => ['label' => 'Confirmar password'],
            ])
        ;
    }

}
