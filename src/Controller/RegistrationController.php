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

class RegistrationController extends Controller
{

    public function userNew(Request $request) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('register.html.twig', array(
           'form' => $form->createView(),
        ));
    }
}