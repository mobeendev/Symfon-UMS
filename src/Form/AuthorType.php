<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter name',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter age',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'label' => 'Country',
                'required' => true,
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'select2 mt-2', "data-placeholder"=>"Select Country" , "data-allow-clear"=>"true", "data-search-input-placeholder"=>"type to search"],
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
