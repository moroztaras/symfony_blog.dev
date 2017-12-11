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
            ->add(
                'created',
                DateType::class,
                [
                    'label' => 'Дата',
                    'widget' => 'single_text',
                    'format' => 'dd.MM.yyyy',
                    'attr' => [
                        'class' => 'form-control datepicker populate-start-at',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd.mm.yyyy',
                    ],
                    'required' => false,
                ]
            )
			->add('title', TextType::class, [
				'required' => false,
				'label' => 'Заголовок',
                'attr' => [
                    'class' => 'form-control',
                ],
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
