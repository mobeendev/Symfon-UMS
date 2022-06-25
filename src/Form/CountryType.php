<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter name',
                    'class' => 'input w-full border mt-2',
                ],                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('code', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxlength' => 3,
                    'placeholder' => 'Enter code',
                    'class' => 'input  w-full border mt-2',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('phone_code', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxlength' => 3,
                    'placeholder' => 'Enter country code',
                    'class' => 'input  w-full border mt-2',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Country::class,
        ]);
    }
}
