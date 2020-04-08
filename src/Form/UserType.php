<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    
        $builder
            ->add('email')
            //->add('roles')
            //->add('password')
            ->add('BirthDate', DateType::class, array(
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')-100),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
              ))
            ->add('FirstName')
            ->add('LastName')
/*            ->add('FavoritMouvie')
            ->add('MouvieToSee')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
