<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 05/01/2018
 * Time: 16:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FriendsController extends Controller {
    public function viewFriends() {
        return $this->render('friends.html.twig');
    }
}