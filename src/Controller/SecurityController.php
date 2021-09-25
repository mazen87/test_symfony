<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        if (!empty($this->getUser())) {
            return $this->redirectToRoute('home');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     *@Route ("/user/{id}" , name="user_profile") 
     */
    public function editProfile(User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $motPassHasher)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $formProfile = $this->createForm(UserProfileType::class, $user);
        $password = $user->getPassword();
        $formProfile->handleRequest($request);
        if ($formProfile->isSubmitted() && $formProfile->isValid()) {
            if (empty($formProfile->get('plainPassword')->getData())) {
                $user->setPassword($password);
            } else {
                $user->setPassword(
                    $motPassHasher->hashPassword($user, $formProfile->get('plainPassword')->getData())
                );
            }

            try {
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Your profile has modified successfully!');
                return $this->redirectToRoute('home');
            } catch (Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
            }
        }
        return $this->render(
            'security/editProfile.html.twig',
            ['formProfile' => $formProfile->createView(), 'user' => $user]
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->redirectToRoute('target_path');
    }
}
