<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class HomeRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label'=>"Pseudonyme",
                'help' => "Longueur minimale : 5 caractères",
                'attr'=>[
                    'placeholder'=>"Choisissez un Pseudonyme"
                ]
            ])
            ->add('email', EmailType::class, [
                'label'=>"Email",
                'attr'=>[
                    'placeholder'=>"Saisissez votre Email"
                ]
            ])
            ->add('birthdayDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'label' => "Date de naissance",
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'js-datepicker'],
                'invalid_message' => "Mauvais format de date"
            ]) 
            ->add('password', PasswordType::class, [
                'label'=>"Saisissez un mot de passe",
                'help'=> "longueur minimale : 8 caractères",
                'attr'=>[
                    'placeholder'=>"Mot de passe"
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
