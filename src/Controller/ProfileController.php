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
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller {
    public function showProfile(Request $request) {
        /** @var User $user */
        $user = $this->getUser();
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: validate if the sender is friend with the receiver
            $post->setTimestamp(new \DateTime());
            $post->setUserFrom($user);
            $post->setUserTo($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            //Empty the form and the object and create new ones
            unset($post);
            unset($form);
            $post = new Post();
            $form = $this->createForm(PostType::class, $post);
        }

        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $postRepository->findBy(array('userTo' => $user->getId()));

        return $this->render('profile.html.twig', array(
            'form' => $form->createView(),
            'posts' => $posts
        ));
    }

    public function deletePost($post_id) {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $post = $postRepository->find($post_id);

        /** @var User $user */
        $user = $this->getUser();

        /** @var User $postOwner */
        $postOwner = $post->getUserTo();

        if ($user->getId() === $postOwner->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('app_profile');
    }
}