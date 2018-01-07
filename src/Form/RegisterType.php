<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 29/12/2017
 * Time: 00:34
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('fullname', TextType::class)
            ->add('email', EmailType::class, array(
                'invalid_message' => 'Email'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_name' => 'password',
                'first_options' => array('label' => 'Password'),
                'second_name' => 'confirmPassword',
                'second_options' => array('label' => 'Confirm Password'),
                'invalid_message' => 'Passwords don\'t match'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'data_class' => User::class
        ));
    }
}