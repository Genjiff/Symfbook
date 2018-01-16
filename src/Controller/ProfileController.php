<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 03/01/2018
 * Time: 01:12
 */

namespace App\Controller;


use App\Entity\Friendship;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller {
    public function showProfile(Request $request, $userId) {
        $status = 'own user';
        /** @var User $loggedUser */
        $loggedUser = $this->getUser();

        $friendshipRepository = $this->getDoctrine()->getRepository(Friendship::class);

        if ($userId == null || $loggedUser->getId() == $userId) {
            /** @var User $user */
            $user = $loggedUser;
        } else {
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->find($userId);

            $status = $friendshipRepository->checkFriendship($loggedUser, $user);
        }

        try {
            $friendCount = $friendshipRepository->countFriendsByUser($user);
        } catch (NonUniqueResultException $e) {
            $friendCount = 0;
        }

        $post = new Post();

        $form = $this->createForm(PostType::class, $post, array(
            'action' => $this->generateUrl('app_write_post')
        ));
        $form->handleRequest($request);

        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $postRepository->findBy(
            array('userTo' => $user->getId()),
            array('timestamp' => 'DESC')
        );

        return $this->render('profile.html.twig', array(
            'form' => $form->createView(),
            'friendCount' => $friendCount,
            'posts' => $posts,
            'status' => $status,
            'user' => $user,
        ));
    }

    public function writePost(Request $request) {

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($post->getUserTo() == null) {
            return $this->redirectToRoute('app_profile');
        } else {
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $userTo = $userRepository->find($post->getUserTo());
        }

        $userFrom = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: validate if the sender is friend with the receiver
            $post->setTimestamp(new \DateTime());
            $post->setUserFrom($userFrom);
            $post->setUserTo($userTo);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('app_profile', array('userId' => $post->getUserTo()->getId())));
    }

    public function deletePost($postId) {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $post = $postRepository->find($postId);

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