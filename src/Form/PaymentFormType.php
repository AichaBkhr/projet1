<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cardNumber', TextType::class, [
                'label' => 'Numéro de carte',
                'required' => true,
            ])
            ->add('expiryDate', TextType::class, [
                'label' => 'Date d\'expiration',
                'required' => true,
                'attr' => [
                    'placeholder' => 'MM/AAAA',
                ],
            ])
            ->add('cvv', TextType::class, [
                'label' => 'CVV',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
