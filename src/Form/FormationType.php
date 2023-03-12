<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('publishedAt', DateType::class, [
         'widget' => 'single_text',
        'required' => true, // champ obligatoire
        'empty_data' => new \DateTime(),
        'data' => isset($options['data']) ? $options['data']->getPublishedAt() : null,
        'label' => 'Date'
        ])
        ->add('title', null, [
            'required' => true // champ obligatoire
        ])
        ->add('description')
        ->add('videoId', null, [
            'required' => true // champ obligatoire
        ])
        ->add('categories', EntityType::class, [
            'label' => 'Categories',
            'class' => Categorie::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
            'required' => true // champ obligatoire
        ])
        ->add('playlist', EntityType::class, [
            'class' => Playlist::class,
            'label' => 'Playlist',
            'choice_label' => 'name',
            'placeholder' => 'Select a playlist',
            'required' => true // champ obligatoire
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Enrengistrer'
        ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
