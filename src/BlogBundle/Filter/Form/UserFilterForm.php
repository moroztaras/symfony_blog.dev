<?php

namespace BlogBundle\Filter\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserFilterForm extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', TextType::class, [
				'required' => false,
				'label' => 'Логін',
                'attr' => [
                    'class' => 'form-control',
                ],
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'BlogBundle\Filter\UserFilter',
			'csrf_protection' => false,
			'method' => 'GET'
		]);
	}

	public function getBlockPrefix() {
		return 'filter';
	}

}
