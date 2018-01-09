<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 03/01/2018
 * Time: 01:12
 */

namespace App\Controller;


use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller {
    public function showProfile() {
        /** @var User $user */
        $user = $this->getUser();

        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        $posts = $postRepository->findBy(array('userTo' => $user->getId()));

        $time = date('Y-m-d\TH:i:s.Z\Z', time());
        return $this->render('profile.html.twig', array(
            'posts' => $posts,
            'time' => $time
        ));
    }
}