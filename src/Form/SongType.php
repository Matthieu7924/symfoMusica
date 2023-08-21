<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class,[
            'attr' =>[
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '50'
            ],
            'label'=>'Titre',
            'label_attr' =>[
                'class' => 'form-label  mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min' => '2', 'max' => '50']),
                new Assert\NotBlank()
            ]
        ])
        ->add('author', TextType::class,[
            'attr' =>[
                'class' => 'form-control', 
            ],
            'required' => false,
            'label'=>'Auteur',
            'label_attr' =>[
                'class' => 'form-label  mt-4'
            ],
            'constraints' => [
                
                new Assert\Positive(),
                new Assert\LessThan(1001)
            ]
        ])
        ->add('youtubeLink', TextType::class, [
            'attr' =>[
                'class' => 'form-control', 
            ],
            'required' => false,
            'label'=>'Lien YouTube',
            'label_attr' =>[
                'class' => 'form-label  mt-4'
            ]
        ])
        ->add('mp3FilePath', TextType::class, [
            'attr' =>[
                'class' => 'form-control', 
            ],
            'required' => false,
            'label'=>'Lien Fichier mp3',
            'label_attr' =>[
                'class' => 'form-label  mt-4'
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
