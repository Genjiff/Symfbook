<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 23/12/2017
 * Time: 13:18
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller {
    public function userNew(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $user = new User();
        $success = false;
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $success = true;

                //Empty the form and the object and create new ones
                unset($user);
                unset($form);
                $user = new User();
                $form = $this->createForm(UserType::class, $user);
            }
        }

        return $this->render('register.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }
}