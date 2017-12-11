<?php

namespace BlogBundle\Filter\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MessageFilterForm extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Автор',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('message', TextType::class, [
				'required' => false,
				'label' => 'Повідомлення',
                'attr' => [
                    'class' => 'form-control',
                ],
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'BlogBundle\Filter\MessageFilter',
			'csrf_protection' => false,
			'method' => 'GET'
		]);
	}

	public function getBlockPrefix() {
		return 'filter';
	}

}
