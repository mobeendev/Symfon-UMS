<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Tag;
use App\Entity\BookTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class BookTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'label' => 'Tag',
                'required' => true,
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'select2 mt-2', "data-placeholder"=>"Select Tag" , "data-allow-clear"=>"true", "data-search-input-placeholder"=>"type to search"],
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
                    new NotBlank(),
                ],
            ])
            ->add('createdAt', DateTimeType::class, [
                'label' => 'Date/Time',
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'input w-full border'],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->addEventListener(
                FormEvents::POST_SET_DATA,
                array($this, 'onPostSetData')
            )
        ;

        ;
    }

    public function onPostSetData(FormEvent $event)
    {
        if ($event->getData() && $event->getData()->getId()) {
            $form = $event->getForm();
            unset($form['tag']);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookTag::class,
        ]);
    }
}
