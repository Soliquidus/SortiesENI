<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\User;
use App\Form\FilesType;
use App\Form\UserType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profil(): Response
    {
        return $this->render('user/profile.html.twig', [
            'edit' => false,
            'edit_password' => false,
            'form' => null,
        ]);
    }

    /**
     * @Route("/profile/edit", name="profile_edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return RedirectResponse|Response
     */
    public function profile_edit(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('password')
            ->remove('submit')
            ->remove('active')
            ->remove('role');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $uploadedFile = $form['picture']->getData();
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                try {
                    $uploadedFile->move(
                        $this->getParameter('user_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $user->setPicture($newFilename);
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Profile updated !');

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/profile.html.twig', [
            'edit' => true,
            'edit_password' => false,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/edit_password", name="profil_edit_password")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function profile_edit_password(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->remove('id')
            ->remove('username')
            ->remove('lastName')
            ->remove('firstName')
            ->remove('phoneNumber')
            ->remove('mail')
            ->remove('campus')
            ->remove('picture')
            ->remove('active')
            ->remove('submit');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user = $form->getData();

            $encoded_password = $encoder->encodePassword($user, $form['password']->getData());
            $user->setPassword($encoded_password);

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Mot de passe modifié !');

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/profile.html.twig', [
            'edit' => false,
            'edit_password' => true,
            'form' => $form->createView(),
        ]);
    }

    public function generateRandomString($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#@-_=$'): string
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
