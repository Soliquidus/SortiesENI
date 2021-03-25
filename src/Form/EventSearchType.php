<?php

namespace App\Form;

use App\Entity\EventSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventSearchType extends AbstractType
{
    //Formulaire pour la recherche de sorties

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Title',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Search title by words in it'
                ]
            ])
            ->add('minDate', DateType::class, [
                'label' => 'Between the',
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('maxDate', DateType::class, [
                'label' => 'and the',
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('ownCreator', CheckboxType::class, [
                'label' => 'Events I manage',
                'required' => false,
                'empty_data' => null,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('subscribed', CheckboxType::class, [
                'label' => 'Events I subscribed to',
                'required' => false,
                'empty_data' => null,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('unsubscribed', CheckboxType::class, [
                'label' => 'Events I\'m not subscribed to',
                'required' => false,
                'empty_data' => null,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('passed', CheckboxType::class, [
                'label' => 'Passed events',
                'required' => false,
                'empty_data' => null,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Search',
                'attr' => [
                    'class' => 'btn btn-primary w-100'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventSearch::class,
            'method' => 'GET',
            'translation_domain' => 'forms',
        ]);
    }
}
