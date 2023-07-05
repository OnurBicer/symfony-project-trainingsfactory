<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Training;
use App\Entity\User;
use App\Form\AdminUpdateType;
use App\Form\InstructorAddUpdateType;
use App\Form\InstructorUpdateType;
use App\Form\LessonAddType;
use App\Form\LessonType;
use App\Form\LessonUpdateType;
use App\Form\TrainingAddType;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InstructAdminController extends AbstractController
{
    #[Route('/instruct', name: 'instructAdmin_home')]
    public function ShowAdministratorHome(): Response
    {
        $name = $this->getUser();
        return $this->render('instructAdmin/home.html.twig', ['name' => $name]);
    }

    #[Route('/instruct/showTrainings', name: 'instructAdmin_trainings')]
    public function ShowGymTrainings(ManagerRegistry $doctrine): Response
    {
        $name = $this->getUser();
        $training = $doctrine->getRepository(Training::class)->findAll();

        return $this->render('instructAdmin/trainings.html.twig', ['name' => $name, 'trainings' => $training]);
    }

    #[Route('/instruct/Training/Add', name: 'instruct_training_add')]
    public function AddGymTrainings(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $name = $this->getUser();

        $training = new Training();

        $form = $this->createForm(TrainingAddType::class, $training);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_trainings');
        }
        return $this->renderForm('instructAdmin/addtrainings.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/Training/delete/{id}', name: 'training_delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $training = $entityManager->getRepository(Training::class)->find($id);


        $entityManager->remove($training);
        $entityManager->flush();

        return $this->redirectToRoute('instructAdmin_trainings', [
            'id' => $training->getId()
        ]);
    }

    #[Route('/instruct/Training/update/{id}', name: 'training_update')]
    public function update(Request $request,ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $training = $entityManager->getRepository(Training::class)->find($id);


        $form = $this->createForm(TrainingAddType::class, $training);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_trainings');
        }
        return $this->renderForm('instructAdmin/trainingUpdate.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/showLessons', name: 'instructAdmin_lessons')]
    public function showLessons(ManagerRegistry $doctrine): Response
    {
        $lessons = $doctrine->getRepository(Lesson::class)->findAll();

        return $this->render('instructAdmin/lessen.html.twig', ['lessons' => $lessons]);
    }

    #[Route('/instruct/Lesson/update/{id}', name: 'instruct_lesson_update')]
    public function updateLesson(Request $request,ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $lesson = $entityManager->getRepository(Lesson::class)->find($id);

        $form = $this->createForm(LessonUpdateType::class, $lesson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_lessons');
        }
        return $this->renderForm('instructAdmin/trainingUpdate.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/lesson/delete/{id}', name: 'lesson_delete')]
    public function deleteLesson(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $lesson = $entityManager->getRepository(Lesson::class)->find($id);


        $entityManager->remove($lesson);
        $entityManager->flush();

        return $this->redirectToRoute('instructAdmin_lessons', [
            'id' => $lesson->getId()
        ]);
    }

    #[Route('/instruct/profile', name: 'instruct_admin_profile')]
    public function showInstructProfile(ManagerRegistry $doctrine): Response
    {
        $name = $this->getUser();

        $admin = $doctrine->getRepository(User::class)->find($name);

        return $this->render('instructAdmin/profiel.html.twig', ['admin' => $admin]);
    }

    #[Route('/instruct/profile/change', name: 'instruct_changeProfile')]
    public function changeInstructProfile(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $name = $this->getUser();

        $admin = $doctrine->getRepository(User::class)->find($name);


        $form = $this->createForm(AdminUpdateType::class, $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_home');
        }
        return $this->renderForm('instructAdmin/profielUpdate.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/showMembers', name: 'instructAdmin_member')]
    public function showMembers(UserRepository $userRepository): Response
    {
        $members = $userRepository->findUsersByRole('ROLE_MEMBER');

        return $this->render('instructAdmin/member.html.twig', ['leden' => $members]);
    }

    #[Route('/instruct/members/update/{id}', name: 'instructAdmin_member_update')]
    public function updateMember(Request $request, int $id, EntityManagerInterface $entityManager) : Response
    {
        $userUpdate = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(UserUpdateType::class, $userUpdate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_member');
        }
        return $this->renderForm('instructAdmin/memberUpdate.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/members/delete/{id}', name: 'instructAdmin_member_delete')]
    public function deleteMember(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $memberDelete = $entityManager->getRepository(User::class)->find($id);

        if (!$memberDelete) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($memberDelete);
        $entityManager->flush();

        return $this->redirectToRoute('instructAdmin_member', [
            'id' => $memberDelete->getId()
        ]);
    }
    #[Route('/instruct/showInstructors', name: 'instructAdmin_instructors')]
    public function showInstructors(UserRepository $userRepository): Response
    {
        $instructors = $userRepository->findUsersByRole('ROLE_ADMIN');

        return $this->render('instructAdmin/instructor.html.twig', ['instructeurs' => $instructors]);
    }

    #[Route('/instruct/instructors/add', name: 'instructAdmin_instructor_add')]
    public function AddInstructor(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $instructorAdd = new User();
        $instructorAdd->setRoles(["ROLE_ADMIN"]);

        $form = $this->createForm(InstructorUpdateType::class, $instructorAdd);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $instructorAdd->setPassword($passwordHasher->hashPassword(
                $instructorAdd,
                $instructorAdd->getPassword()
            ));

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_instructors');
        }
        return $this->renderForm('instructAdmin/instructorAdd.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/instructors/update/{id}', name: 'instructAdmin_instructor_update')]
    public function updateInstructor(Request $request, int $id, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher) : Response
    {
        $instructorUpdate = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(InstructorAddUpdateType::class, $instructorUpdate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();

            $instructorUpdate->setPassword($passwordHasher->hashPassword(
                $instructorUpdate,
                $instructorUpdate->getPassword()
            ));

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('instructAdmin_instructors');
        }
        return $this->renderForm('instructAdmin/instructorUpdate.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instruct/members/delete/{id}', name: 'instructAdmin_instructor_delete')]
    public function deleteInstructor(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $instructorDelete = $entityManager->getRepository(User::class)->find($id);

        if (!$instructorDelete) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($instructorDelete);
        $entityManager->flush();

        return $this->redirectToRoute('instructAdmin_instructors', [
            'id' => $instructorDelete->getId()
        ]);
    }
}