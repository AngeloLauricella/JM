<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    /**
     * Ce controller sert a mofifier un user
     *
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/utilisateur/edition/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_inscription');
        }
        if (!$this->getUser() === $user) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'Success',
                    'Votre compte a bien été Modifiée !'
                );

                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash(
                    'Warning',
                    'Le mot de passe saisi est incorrect.'
                );
                return $this->redirectToRoute('app_user_edit');
            }
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'app_user_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordType::class);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->getData()['newPassword']
                    )
                );
                
    
                $this->addFlash(
                    'motDePass',
                    'Votre mot de passe a bien été modifié !'
                );
                
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('app_home');
            } else {   
                $this->addFlash(
                    'erreurMotDePass',
                    'Le mot de passe saisi est incorrect.'
                );
    
                return $this->redirectToRoute('app_user_edit_password');
            }
        }
    
        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
    
