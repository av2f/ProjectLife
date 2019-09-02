<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('gender')
            //->add('password')
            ->add('firstName', TextType::class, [
                'label'=>"Prénom",
                'attr'=>[
                    'placeholder'=>"Saisissez votre prénom"
                ]
            ])
            ->add('lastName', TextType::class, [
                'label'=>"Nom",
                'attr'=>[
                    'placeholder'=>"Saisissez votre Nom"
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
            ->add('email', EmailType::class, [
                'label'=>"Email",
                'attr'=>[
                    'placeholder'=>"Saisissez votre Email"
                ]
            ])
            //->add('situation')
            ->add('profession', TextType::class, [
                'label'=>"Profession",
                'attr'=>[
                    'placeholder'=>"Saisissez votre profession"
                ]
            ])
            //->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
