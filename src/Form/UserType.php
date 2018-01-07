<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 06/01/2018
 * Time: 22:23
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'disabled' => true
            ))
            ->add('fullname', TextType::class)
            ->add('email', EmailType::class, array(
                'invalid_message' => 'Email'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => false,
                'first_name' => 'password',
                'first_options' => array('label' => 'Password'),
                'second_name' => 'confirmPassword',
                'second_options' => array('label' => 'Confirm Password'),
                'invalid_message' => 'Passwords don\'t match'
            ))
            ->add('profilePicture', FileType::class, array(
                'required' => false
            ))
            ->add('aboutMe', TextareaType::class, array(
                'required' => false
            ))
            ->add('education', TextType::class, array(
                'required' => false
            ))
            ->add('age', IntegerType::class, array(
                'required' => false,
                'invalid_message' => 'Only numbers are allowed in this field.'
            ))
            ->add('location', TextType::class, array(
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}