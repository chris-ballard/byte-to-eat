<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order', TextareaType::class, [
                'label' => 'What would you like to order?',
                'required' => false,
            ])
            ->add('starter', ChoiceType::class, [
                'choices' => $options['starter_choices'],
                'label' => 'Starter',
                'placeholder' => 'None',
                'required' => false,
                'disabled' => true,
            ])
            ->add('main_course', ChoiceType::class, [
                'choices' => $options['main_course_choices'],
                'label' => 'Main Course',
                'placeholder' => 'None',
                'required' => false,
                'disabled' => true,
            ])
            ->add('dessert', ChoiceType::class, [
                'choices' => $options['dessert_choices'],
                'label' => 'Dessert',
                'placeholder' => 'None',
                'required' => false,
                'disabled' => true,
            ])
            ->add('ask_order_assistant', SubmitType::class, [
                'label' => 'Ask Order Assistant'
            ])
            ->add('place_order', SubmitType::class, [
                'label' => 'Place Order',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'starter_choices' => [],
            'main_course_choices' => [],
            'dessert_choices' => [],
        ]);
    }
}
