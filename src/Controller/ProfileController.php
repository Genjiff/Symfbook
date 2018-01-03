<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 03/01/2018
 * Time: 01:12
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller {
    public function showProfile() {
        return $this->render('profile.html.twig');
    }
}