<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 09/01/2018
 * Time: 14:15
 */

namespace App\Form;


use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('message', TextareaType::class)
            ->add('userTo', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Post::class
        ));
    }
}