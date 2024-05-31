<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', ChoiceType::class, [
                'label' => 'Услуга',
                'choices'  => [
                    'Выберите' => '',
                    'Оценка стоимости авто' => 1,
                    'Оценка стоимости квартиры' => 2,
                    'Оценка стоимости бизнеса' => 3,
                ],
                'choice_attr' => [
                    'Оценка стоимости авто' => ['data-coast' => '500'],
                    'Оценка стоимости квартиры' => ['data-coast' => '1000'],
                    'Оценка стоимости бизнеса' => ['data-coast' => '10000'],
                ],
                'required' => true,
                'empty_data' => '',
            ])
            ->add('email', TextType::class, [
                  'label' => 'Электроная почта'
            ])
            ->add('coast', TextType::class, [
                  'label' => 'Стоимость',
                  'empty_data' => '0',
                  'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
