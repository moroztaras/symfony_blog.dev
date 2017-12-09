<?php

namespace BlogBundle\Filter\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BlogFilterForm extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', TextType::class, [
				'required' => false,
				'label' => 'Заголовок'
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'BlogBundle\Filter\BlogFilter',
			'csrf_protection' => false,
			'method' => 'GET'
		]);
	}

	public function getBlockPrefix() {
		return 'filter';
	}

}
