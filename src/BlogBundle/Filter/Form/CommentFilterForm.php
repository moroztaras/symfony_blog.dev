<?php

namespace BlogBundle\Filter\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CommentFilterForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextType::class, [
                'required' => false,
                'label' => 'Коментарій',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlogBundle\Filter\CommentFilter',
            'csrf_protection' => false,
            'method' => 'GET'
        ]);
    }

    public function getBlockPrefix() {
        return 'filter';
    }

}