<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;


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
            ->add('bookTags', CollectionType::class, [
                'entry_type' => BookTagType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'button mt-2 w-20 bg-theme-9 text-white ml-3 navigation'
                ],
                'label' => 'Save',
            ]);

            $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

        ;
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $data['bookTags'] = array_values($data['bookTags']);
        $event->setData($data);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
