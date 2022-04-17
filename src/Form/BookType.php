<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Tags;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter Title',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],

                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Price',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter Price',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],

                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'label' => 'Author',
                'required' => true,
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'select2 mt-2', "data-placeholder"=>"Select Author" , "data-allow-clear"=>"true", "data-search-input-placeholder"=>"type to search"],
                'constraints' => [
                    new NotBlank(null,'Please select author'),
                ],
            ])
            ->add('tag', EntityType::class, [
                'class' => Tags::class,
                'required' => true,
                'multiple' => true,
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'select2 mt-2', "data-placeholder"=>"Select Author" , "data-allow-clear"=>"true", "data-search-input-placeholder"=>"type to search"],
                'constraints' => [
                    new NotBlank(null,'Please select author'),
                ],
            ])
            ->add('topic', TextType::class, [
                'label' => 'Topic',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter Topic',
                    'class' => 'input payment-type authcode w-full border mt-2',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('publishedDate', DateType::class, [
                'label' => 'Date/Time',
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr' => [
                    'class' => 'input w-full border mt-2',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('color', TextType::class, [
                'required' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'input payment-type w-full border mt-2',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'button mt-2 w-20 bg-theme-9 text-white ml-3 navigation'
                ],
                'label' => 'Save',
            ]);


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
