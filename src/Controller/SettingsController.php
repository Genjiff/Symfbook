<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 03/01/2018
 * Time: 18:26
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile as uploadedfile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SettingsController extends Controller {
    public function settingsPage(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        /** @var User $user */
        $user = $this->getUser();

        /** @var string $lastProfilePicture */
        $lastProfilePicture = $user->getProfilePicture();

        // Set full path of the profile picture because of form validator
        $lastProfilePicturePath = $this->getParameter('profile_pictures_directory').'/'.$user->getProfilePicture();

        if ($lastProfilePicture !== null) {
            $user->setProfilePicture(
                new File($lastProfilePicturePath)
            );
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword() !== null) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }

            /** @var uploadedfile $file */
            $file = $user->getProfilePicture();

            if ($file !== null) {
                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('profile_pictures_directory'),
                    $fileName
                );

                unlink($lastProfilePicturePath);

                $user->setProfilePicture($fileName);
            } else {
                //If there is no new file, reset the profile picture field to only the picture filename
                $user->setProfilePicture($lastProfilePicture);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        } else {
            // Only the profile picture filename is passed to the view if the form is not submitted
            $user->setProfilePicture($lastProfilePicture);
        }

        return $this->render('settings.html.twig', array(
            'form' => $form->createView()
        ));
    }
}