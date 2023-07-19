<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType as TypeRepeatedType;
use Symfony\Component\Validator\Constraints as Assert;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'attr' => [
                    'class' => 'name',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom/Prénom',
                'label_attr' => [
                    'class' => 'nameType'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50]),

                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'name',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],
                'required' => false,
                'label' => 'Pseudo (Facultatif)',
                'label_attr' => [
                    'class' => 'nameclass'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),

                ]
            ])
            ->add('plainPassword',PasswordType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form-label'
                    ],  
                'invalid_message' => 'les mots de passe ne corresponde pas .',
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'mybutton',
                    ],
                    'label' => 'modifier'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
