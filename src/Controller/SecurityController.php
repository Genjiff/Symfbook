<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31/12/2017
 * Time: 20:22
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller {
    public function indexPage (UserInterface $user = null) {
        if($user == null) {
            return $this->redirectToRoute('app_login');
        } else {
            return $this->redirectToRoute('app_profile');
        }
    }

    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }

    public function logout() {

    }
}