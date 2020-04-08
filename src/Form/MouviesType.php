<?php

namespace App\Form;

use App\Entity\Mouvies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MouviesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('popularity')
            ->add('vote_count')
            ->add('video')
            ->add('poster_path')
            ->add('adult')
            ->add('backdrop_path')
            ->add('original_language')
            ->add('original_title')
            ->add('genre_ids')
            ->add('title')
            ->add('vote_average')
            ->add('overview')
            ->add('release_date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mouvies::class,
        ]);
    }
}
