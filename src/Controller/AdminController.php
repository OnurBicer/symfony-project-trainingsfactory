<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Entity\User;
use App\Form\AdminUpdateType;
use App\Form\LessonUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Lesson;
use App\Form\LessonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function ShowAdminHome(): Response
    {
        $name = $this->getUser();
        return $this->render('admin/home.html.twig', ['name' => $name]);
    }

    #[Route('/admin/lesson', name: 'admin_lesson')]
    public function ShowAdminLesson(ManagerRegistry $doctrine): Response
    {
        $name = $this->getUser();

        $lessons = $doctrine->getRepository(Lesson::class)->findBy(['instructor' => $name]);

        return $this->render('admin/lessen.html.twig', ['name' => $name, 'lesson' => $lessons]);
    }

    #[Route('/admin/lesson/participants/{id}', name: 'admin_lesson_participate')]
    public function ShowLessonParticipants(ManagerRegistry $doctrine, UserRepository $userRepository, int $id): Response
    {
        $name = $this->getUser();

        $participants = $doctrine->getRepository(Lesson::class)->find($id);

        return $this->render('admin/deelnemers.html.twig', ['name' => $name, 'deelnemers' => $participants]);
    }


    #[Route('/admin/lesson/add', name: 'lesson_add')]
    public function MakeLesson(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lesson = new Lesson();
        $lesson->setInstructor($this->getUser());

        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $add = $form->getData();
            $entityManager->persist($add);
            $entityManager->flush();

            $this->addFlash('SUCCESS', 'Les toegevoegd aan het schema');
            return $this->redirectToRoute('admin_home');
        }
        return $this->renderForm('admin/insert.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/lesson/update/{id}', name: 'lesson_edit')]
    public function update(Request $request, int $id, EntityManagerInterface $entityManager) : Response
    {
        $lessonUpdate = $entityManager->getRepository(Lesson::class)->find($id);

        $form = $this->createForm(LessonUpdateType::class, $lessonUpdate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            $this->addFlash('warning', 'Les gewijzigd');
            return $this->redirectToRoute('admin_home');
        }
        return $this->renderForm('admin/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/lesson/delete/{id}', name: 'delete_lesson' )]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $lesDelete = $entityManager->getRepository(Lesson::class)->find($id);

        if (!$lesDelete) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($lesDelete);
        $entityManager->flush();

        $this->addFlash('danger', 'Les verwijderd');
        return $this->redirectToRoute('admin_home', [
            'id' => $lesDelete->getId()
        ]);
    }
    #[Route('/admin/profile', name: 'admin_profile')]
    public function showAdminProfile(ManagerRegistry $doctrine): Response
    {
        $name = $this->getUser();

        $admin = $doctrine->getRepository(User::class)->find($name);

        return $this->render('admin/profiel.html.twig', ['admin' => $admin]);
    }

    #[Route('/admin/profile/change', name: 'admin_changeProfile')]
    public function changeAdminProfile(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $name = $this->getUser();

        $admin = $doctrine->getRepository(User::class)->find($name);


        $form = $this->createForm(AdminUpdateType::class, $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            $this->addFlash('SUCCESS', 'Uw gegevens zijn gewijzigd');
            return $this->redirectToRoute('admin_home');
        }
        return $this->renderForm('admin/profileUpdate.html.twig', [
            'form' => $form,
        ]);
    }
}