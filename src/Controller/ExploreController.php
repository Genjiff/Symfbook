<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 05/01/2018
 * Time: 18:49
 */

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExploreController extends Controller {
    public function showExplore() {
        /** @var User $user */
        $user = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepository->findAllExceptUser($user);

        return $this->render("explore.html.twig", array(
            'users' => $users
        ));
    }
}