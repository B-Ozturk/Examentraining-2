<?php

namespace App\Form;

use App\Entity\Autovoorraad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prijs',IntegerType::class, [
                'required' => true,
                'empty_data' => 'Score',
                'attr' => array('min' => 10000)])
            ->add('voorraad', IntegerType::class, [
                'required' => true,
                'empty_data' => 'Score',
                'attr' => array('min' => 1)])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Autovoorraad::class,
        ]);
    }
}
