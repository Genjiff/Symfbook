<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 05/01/2018
 * Time: 16:38
 */

namespace App\Controller;


use App\Entity\Friendship;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FriendshipController extends Controller {
    public function viewFriends() {
        return $this->render('friends.html.twig');
    }

    public function addFriend($userId) {
        /** @var User $user1 */
        $user1 = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user2 = $userRepository->find($userId);

        $friendshipRepository = $this->getDoctrine()->getRepository(Friendship::class);
        $check = $friendshipRepository->checkFriendship($user1, $user2);

        if ($user1 != $user2 && $check === false) {
            $friendshipRequest = new Friendship();

            $friendshipRequest->setUser1($user1);
            $friendshipRequest->setUser2($user2);
            $friendshipRequest->setStatus("pending");

            $em = $this->getDoctrine()->getManager();
            $em->persist($friendshipRequest);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('app_profile', array('userId' => $userId)));
    }

    public function friendRequests() {
        /** @var User $user */
        $user = $this->getUser();

        $friendshipRepository = $this->getDoctrine()->getRepository(Friendship::class);
        $pendingRequests = $friendshipRepository->findPendingRequestsByUser($user);

        return $this->render('friendRequests.html.twig', array(
            'requests' => $pendingRequests
        ));
    }

    public function cancelFriendRequest($userId) {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user1 = $userRepository->find($userId);

        $user2 = $this->getUser();

        $friendshipRepository = $this->getDoctrine()->getRepository(Friendship::class);
        $fr = $friendshipRepository->findOneBy(array(
            'user1' => $user1,
            'user2' => $user2,
            'status' => 'pending'
        ));

        if ($fr != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fr);
            $em->flush();
        }

        return $this->redirectToRoute('app_friend_requests');
    }

    public function confirmFriendRequest($userId) {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user1 = $userRepository->find($userId);

        $user2 = $this->getUser();

        $friendshipRepository = $this->getDoctrine()->getRepository(Friendship::class);
        $fr = $friendshipRepository->findOneBy(array(
            'user1' => $user1,
            'user2' => $user2,
            'status' => 'pending'
        ));

        if ($fr != null) {
            $fr->setStatus('confirmed');

            $em = $this->getDoctrine()->getManager();
            $em->persist($fr);
            $em->flush();
        }

        return $this->redirectToRoute('app_friend_requests');
    }
}