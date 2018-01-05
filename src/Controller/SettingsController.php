<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 03/01/2018
 * Time: 18:26
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SettingsController extends Controller {
    public function settingsPage() {
        return $this->render('settings.html.twig');
    }
}