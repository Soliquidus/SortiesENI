<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\EventType;
use App\Form\FilesType;
use App\Form\UserType;
use App\Repository\EventRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /**
     * @var EventRepository
     */
    private $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/eventsAdmin", name="eventsAdmin")
     * @param Request $request
     * @param EventRepository $sr
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function eventIndex(Request $request, EventRepository $sr,
                               EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $events = $paginator->paginate($this->repository->IndexQuery(),
            $request->query->getInt('page', 1), 12);

        return $this->render('admin/event/index.html.twig', [
            'events' => $events
        ]);
    }

    /**
     * @Route("/eventsAdmin/add", name="add_eventAdmin")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function eventAdd(Request $request, EntityManagerInterface $em)
    {
        $event = new Event();
        $addresses = new Address();
        $formAddresses = $this->createForm(AddressType::class, $addresses);
        $formAddresses->handleRequest($request);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        $addresses = $em->getRepository(City::class)->findAll();

        if ($formAddresses->isSubmitted() && $formAddresses->isValid()) {
            $addresses = $formAddresses->getData();
            $event->setCreationDate(new \DateTime('now'));
            $event = $form->getData();
            $formResend = $this->createForm(EventType::class, $event);
            $formResend->handleRequest($request);

            $em->persist($addresses);
            $em->flush();
            $this->addFlash('success', 'Address added!');

        }

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setState('Ouvert');
            $event->setCreationDate(new \DateTime('now'));

            if( $form->get('save')->isClicked()){
                $event->setState('Being created');
            }elseif( $form->get('publish')->isClicked()){
                $event->setState('Open');
            }else{
                return $this->redirectToRoute('events');
            }

            $event->setCreator($this->getUser());

            $em->persist($event);
            $em->flush();
            $this->addFlash('success', 'Event published!');
            return $this->redirectToRoute('events');
        }

        return $this->render('admin/event/add.html.twig', [
            'form' => $form->createView(),
            'formAddresses' => $formAddresses->createView(),
            'addresses' => $addresses]);
    }

    /**
     * @Route("/eventsAdmin/edit/{id}", name="edit_eventAdmin")
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function eventEdit(Event $event, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            if ($form->get('save')->isClicked()) {
                $event->setState('Being created');
            } elseif ($form->get('publish')->isClicked()) {
                $event->setState('Open');
            } else {
                return $this->redirectToRoute('eventsAdmin');
            }

            $em->persist($event);
            $em->flush();
            $this->addFlash('success', 'Event updated!');

            return $this->redirectToRoute('eventsAdmin');
        }

        return $this->render('admin/event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("eventsAdmin/delete/{id}", name="delete_eventAdmin")
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function eventDelete(Event $event, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $event = $em->getRepository(Event::class)->find($request->get('id'));
        $em->remove($event);
        $em->flush();
        $this->addFlash('success', 'Event deleted.');

        return $this->redirectToRoute('eventsAdmin');
    }


    /**
     * @Route("/users", name="users")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function usersIndex(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('picture')
            ->remove('password');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_id = $form['id']->getData();
            $user = $em->getRepository(User::class)->findOneById($user_id);

            $user_new = new User();
            $user_new = $form->getData();

            $user->setUsername($user_new->getUsername());
            $user->setLastName($user_new->getLastName());
            $user->setFirstName($user_new->getFirstName());
            $user->setPhoneNumber($user_new->getPhoneNumber());
            $user->setEmail($user_new->getEmail());
            $user->setCampus($user_new->getCampus());
            $user->setActive($user_new->isActive());

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'User ' . $user->getUsername() . ' has been updated !');
        }

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/users/delete", name="delete_user")
//     * @param Request $request
//     * @param EntityManagerInterface $em
//     * @return RedirectResponse
//     */
//    public function deleteUser(Request $request, EntityManagerInterface $em): RedirectResponse
//    {
//        $user_id = $request->request->get('user')['id'];
//        if ($this->getUser()->getId() != $user_id) {
//            $user = $em->getRepository(User::class)->findOneById($user_id);
//            $user_username = $user->getUsername();
//            if (sizeof($user->getEventsCreated()) == 0) {
//                $em->remove($user);
//                $em->flush();
//
//                $this->addFlash('success', 'User ' . $user_username . ' updated !');
//            } else {
//                $this->addFlash('danger', 'User created one or several events.');
//            }
//        } else {
//            $this->addFlash('danger', 'You can\'t delete this user.');
//        }
//
//        return $this->redirectToRoute('users');
//    }


    /**
     * @Route("/users/import", name="import_user")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param FileUploader $fileUploader
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function importUser(Request $request, EntityManagerInterface $em, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(FilesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            if ($file) {
                $file = fopen($file, 'r');
                $data = [];

                while (($line = fgetcsv($file)) !== FALSE) {
                    array_push($data, $line[0]);
                }
                fclose($file);

                foreach ($data as $line) {
                    $splited_line = explode(";", $line);
                    $splited_line[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $splited_line[0]);
                    if ($splited_line[0] != 'username') {
                        $user = new User();
                        $user->setUsername($splited_line[0]);
                        $user->setLastName($splited_line[1]);
                        $user->setFirstName($splited_line[2]);
                        $user->setPhoneNumber($splited_line[3]);
                        $user->setEmail($splited_line[4]);

                        $campus = $em->getRepository(Campus::class)->findOneByLastCampusName($splited_line[5]);
                        if (is_null($campus)) {
                            $campus = new Campus();
                            $campus->setCampusName($splited_line[5]);
                            $em->persist($campus);
                        }
                        $user->setCampus($campus);

                        $encoded_password = $encoder->encodePassword($user, $splited_line[6]);
                        $user->setPassword($encoded_password);

                        $user->setActive(true);

                        $em->persist($user);
                    }
                }

                $em->flush();
                $this->addFlash('success', 'Import succeeded !');

            } else {
                $this->addFlash('danger', 'Unable to open file.');
            }
        }

        return $this->render('admin/user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/add", name="add_user")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param FileUploader $fileUploader
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function addUser (Request $request, EntityManagerInterface $em, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->remove('id');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $role = $form['role']->getData();
            $role = array(0 => $role);
            $user->setRoles($role);

            $pictureFile = $form->get('picture')->getData();

            if($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $user->setPicture($pictureFileName);
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'New user');
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/user/add.html.twig', [
            'users' => null,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/users/{id}", name="edit_user")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function editUser(User $user, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->remove('submit');
        $form->remove('password');

        $form->add('submit',SubmitType::class, [
            'label' => 'Update user',
            'attr' => [
                'class' => 'btn btn-primary w-100'
            ]
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'User updated!');

            $users = $em->getRepository(User::class)->findAll();

            return $this->redirectToRoute('users');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/users/delete/{id}", name="delete_user")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function deleteUser(User $user, Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->find($request->get('id'));
        
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'User deleted!');
        
        return $this->redirectToRoute('users');
    }
}


