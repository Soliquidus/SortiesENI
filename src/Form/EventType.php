<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label' => false,
            ])
            ->add('beginsAt',DateTimeType::class,[
                'label'    => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                  ],
                'required'      => true,
//                'mapped' => false
            ])
            ->add('duration',TextType::class, [
                'label' => false
            ])
            ->add('endsAt',DateTimeType::class,[
                'label'    => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                  ],
                'required'      => true,
            ])
            ->add('subscriptionsMax',IntegerType::class, [
                'label' => 'Max subscribers'
            ])
            ->add('description',TextareaType::class, [
                'label' => false
            ])
            ->add('urlPicture', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('campus',EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'campusName',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.campusName', 'ASC');
                }
            ])
            ->add('city', EntityType::class, [
                'mapped' => false,
                'class' => City::class,
                'placeholder' => '-- Choose a city --'
            ])
            ->add('publish', SubmitType::class, [
                'label' => 'Publish',
                'attr' => [
                    'class' => 'btn-primary btn save w-100'
                ]
            ])
            ->add('save', SubmitType::class,[
                'label' =>'Save',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
            ->add('cancel', SubmitType::class,[
                'label' =>'Cancel',
                'attr' => [
                    'class' => 'btn btn-danger w-100'
                ]
            ])
            ->add('addAddress', SubmitType::class, [
                'label' => 'Add address',
                'attr' => [
                    'class' => 'btn btn-success w-100',
                ]
            ])
            ->add('newAddress', AddressType::class, [
                'label' => 'Address'
            ])
            ->add('saveWithAddress', SubmitType::class, [
                'label' =>'Publish with new address',
                'attr' => [
                    'class' => 'btn btn-primary w-100'
                ]
            ])
        ;

        $formModifier = function (FormInterface $form, City $city = null) {
            $addresses = null === $city ? [] : $city->getAddresses();
            $form->add('address', EntityType::class, [
                    'class' => Address::class,
                    'placeholder' => '-- Choose an address --',
                    'choices' => $addresses
                ]
            );
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $city = ($data->getAddress() !== null)?$data->getAddress()->getCity():null;
                $formModifier($event->getForm(), $city);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $city = ($data->getAddress() !== null)?$data->getAddress()->getCity():null;
                $event->getForm()->get('city')->setData($city);
            }
        );

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {
                if (in_array(
                    'saveWithAddress',
                    $event
                        ->getForm()
                        ->getConfig()
                        ->getOption('validation_groups')($event->getForm())
                )) {
                    $address = $event->getForm()->get('newAddress')->getData();
                    $event->getForm()->getData()->setAddress($address);
                }
            }
        );

        $builder->get('city')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $city = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $city);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'validation_groups' => function(FormInterface $form){
                if ($form->get('saveWithAddress')->isClicked()) {
                    return ["saveWithAddress"];
                }
                return ['save'];
            },
            'translation_domain' => 'forms'
        ]);
    }
}
