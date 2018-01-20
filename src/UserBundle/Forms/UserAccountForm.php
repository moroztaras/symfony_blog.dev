<?php
namespace UserBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAccountForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'label' => 'Ім\'я'
        ]);
        $builder->add('lastName', TextType::class, [
            'label' => 'Прізвище'
        ]);

        $builder->add('birthday', BirthdayType::class, [
            'label' => 'Дата народження'
        ]);
        $builder->add('region', CountryType::class, [
            'label' => 'Країна'
        ]);
        $builder->add('submit', SubmitType::class,[
            'label' => 'Зберегти'
        ]);
    }
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\UserAccount'
        ]);
    }
}