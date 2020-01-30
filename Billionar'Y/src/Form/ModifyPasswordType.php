<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class MofifyPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'le mot de passe n\'est pas confirmer.',
            'first_options' => [
                'label' => 'Password',
                'attr' => [
                    'placeholder' => "Password",
                    'class' => "input_register"
                ]
            ],
            'second_options' => [
                'label' => 'Répeter password',
                'attr' => [
                    'placeholder' => "Répeter Password",
                    'class' => "input_register"
                ]
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
