<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, array('label' => 'Заголовок'))
            ->add('summary', TextareaType::class, array('label' => 'Короткий опис'))
            ->add('body', TextareaType::class, array('label' => 'Повний опис'))
            ->add('tags',TextType::class, array('label' => 'Теги'))
            ->add('description',TextType::class, array('label' => 'Description'))
            ->add('imageFile', VichImageType::class, array('label' => 'Постер','required' => true))
            ->add('save', SubmitType::class, array('label' => 'Зберегти'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Blog',
        ));
    }
}