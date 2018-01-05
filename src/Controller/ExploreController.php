<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 05/01/2018
 * Time: 18:49
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExploreController extends Controller {
    public function showExplore() {
        return $this->render("explore.html.twig");
    }
}