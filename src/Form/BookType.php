<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'constraints' => [
                        new Regex([
                            /**
                             * accept lettres,numbers ,under score, dash, apostrophe
                             */
                            'pattern' => '/^([a-zA-Z0-9éèàùûêâôëç_\-\'])(?:[\s\'-]?(?1))*$/',
                            'message' => 'This value is not valid. !'
                        ])
                    ],
                    'attr' => [
                        'placeholder' => 'Titre..',
                        'class'       => 'form-control'
                    ]
                ]
            )
            ->add(
                'author',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'constraints' => [
                        new Regex([
                            /**
                             * accept lettres ,under score, dash, apostrophe
                             */
                            'pattern' => '/^([a-zA-Z-éèàùûêâôëç_\-\'])(?:[\s\'-]?(?1))*$/',
                            'message' => 'This value is not valid. !'
                        ])
                    ],
                    'attr' => [
                        'placeholder' => 'Author..',
                        'class'       => 'form-control'
                    ]
                ]
            )
            ->add(
                'date',
                DateType::class,
                [
                    'widget' => 'choice',

                ]
            )
            ->add(
                'summary',
                TextareaType::class,
                [
                    'label' => false,
                    'required'    => false,
                    'attr' => [
                        'placeholder' => 'Summary...',
                        'class'       => 'form-control'
                    ]
                ]
            )
            ->add(
                'isbn13',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'ISBN..',
                        'class'       => 'form-control'
                    ]
                ]
            )
            ->add(
                'url',
                UrlType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => "http://www.test_symfony@example.com",
                        'class' => 'form-control'
                    ]
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
