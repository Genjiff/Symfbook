<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 23/12/2017
 * Time: 13:18
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends Controller
{
    public function register () {
        return $this->render('register.html.twig');
    }
}