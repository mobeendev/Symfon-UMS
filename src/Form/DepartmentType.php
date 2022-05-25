<?php

namespace App\Form;

use App\Entity\Department;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DepartmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter name',
                    'class' => 'input payment-type w-full border mt-2',
                ],                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('established_date', DateType::class, [
                'label' => 'Date/Time',
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'input w-full border'],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Product description',
                'attr' => ['class' => 'input mt-2 w-full bg-gray-200 pl-4 py-6 placeholder-theme-13 resize-none', 'rows' => 2, 'placeholder' => 'enter description here'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 1000,
                    ]),
                ],
            ])
            ->add('code', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter name',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('contact', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter name',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Department::class,
        ]);
    }
}
