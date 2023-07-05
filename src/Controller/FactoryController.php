<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\UserType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class FactoryController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function showHome(): Response
    {
        return $this->render('bezoeker/home.html.twig');
    }


    #[Route('/login', name: 'login')]
    public function login():Response{
        return new Response('login');
    }

    #[Route('/register', name: "register")]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setRoles(["ROLE_MEMBER"]);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $user->setPassword($passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            ));
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('SUCCESS', 'gebruiker toegevoegd. U kunt nu inloggen');
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('bezoeker/register.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/trainingen', name: 'training')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $training = $doctrine->getRepository(Training::class)->findAll();

        return $this->render('bezoeker/trainingen.html.twig', [
            'training' => $training
        ]);
    }
}