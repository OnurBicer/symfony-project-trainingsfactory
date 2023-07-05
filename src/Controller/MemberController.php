<?php

namespace App\Controller;


use App\Entity\Lesson;
use App\Entity\Registration;
use App\Entity\Training;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UserUpdateType;
use App\Repository\LessonRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MemberController extends AbstractController
{
    #[Route('/member', name: 'member_home')]
    public function ShowMemberHome(): Response
    {
        $name = $this->getUser();

        return $this->render('member/home.html.twig', ['name' => $name]);
    }

    #[Route('/member/lesson', name: 'member_lesson')]
    public function MemberLessons(ManagerRegistry $doctrine): Response
    {
        $training = $doctrine->getRepository(Training::class)->findAll();

        return $this->render('member/trainingen.html.twig', [
            'training' => $training
        ]);
    }

    #[Route('/member/lesson/{id}', name: 'member_training')]
    public function memberLesson(ManagerRegistry $doctrine, int $id) : Response
    {
        $lessons = $doctrine->getRepository(Training::class)->find($id);

        $products = $lessons->getLesson();

        return $this->render('member/lestijden.html.twig',
            [
                'lessen' => $products,
            ]);
    }

    #[Route('/member/lesson/add/{id}', name: 'member_add')]
    public function estimate(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $reg = new Registration();
        $reg->setUser($this->getUser());

        $form = $this->createForm(RegistrationType::class, $reg);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $add = $form->getData();
            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('member_home');
        }
        return $this->renderForm('member/inschrijving.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/member/profile', name: 'member_profile')]
    public function ShowMemberProfile(ManagerRegistry $doctrine): Response
    {
        $name = $this->getUser();

        $member = $doctrine->getRepository(User::class)->find($name);

        $lessons = $doctrine->getRepository(Registration::class)->findBy(['user' => $name]);

        return $this->render('member/profiel.html.twig', ['member' => $member, 'lessen' => $lessons]);
    }

    #[Route('/member/profile/change', name: 'member_changeProfile')]
    public function ChangeMemberProfile(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $name = $this->getUser();

        $member = $doctrine->getRepository(User::class)->find($name);

        $form = $this->createForm(UserUpdateType::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            $this->addFlash('SUCCESS', 'Uw gegevens zijn gewijzigd');
            return $this->redirectToRoute('member_home');
        }
        return $this->renderForm('member/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/member/profile/delete/{id}', name: 'member_deleteLesson')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $oefeningDelete = $entityManager->getRepository(Registration::class)->find($id);

        if (!$oefeningDelete) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($oefeningDelete);
        $entityManager->flush();

        return $this->redirectToRoute('member_profile', [
            'id' => $oefeningDelete->getId()
        ]);
    }
}