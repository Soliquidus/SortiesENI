<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\EventSearch;
use App\Entity\Subscription;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\CancelEventType;
use App\Form\ContactType;
use App\Form\EventSearchType;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\ContactNotification;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{

    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var null
     */
    private $events = null;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/events", name="events")
     * @param Request $request
     * @param EventRepository $sr
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, EventRepository $sr,
                          EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $unsubscribed = null;
        $subscribed = null;
        $search = new EventSearch();
        $form = $this->createForm(EventSearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ownCreator = $form['ownCreator']->getData();
            $subscribed = $form['subscribed']->getData();
            $unsubscribed = $form['unsubscribed']->getData();
            $passed = $form['passed']->getData();

            $logUser = $em->getRepository(User::class)->find($this->getUser()->getId());
            $events = $paginator->paginate($this->repository->SearchQuery($search, $logUser, $ownCreator, $passed, $subscribed),
                $request->query->getInt('page', 1), 12);
        }
        else {
            $events = $paginator->paginate($this->repository->IndexQuery(),
                $request->query->getInt('page', 1), 12);
        }

        return $this->render('event/index.html.twig', [
            'unsubscribed' => $unsubscribed,
            'subscribed' => $subscribed,
            'form' => $form->createView(),
            'events' => $events,
        ]);
    }

    /**
     * @Route("/events/add", name="add_event")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function add(Request $request, EntityManagerInterface $em)
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

        return $this->render('event/add.html.twig', [
            'form' => $form->createView(),
            'formAddresses' => $formAddresses->createView(),
            'addresses' => $addresses]);
    }

    /**
     * @Route("/events/edit/{id}", name="edit_event")
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Event $event, Request $request, EntityManagerInterface $em)
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
                return $this->redirectToRoute('events');
            }

            $em->persist($event);
            $em->flush();
            $this->addFlash('success', 'Event updated!');

            $this->events = $em->getRepository(Event::class)->findAll();

            return $this->redirectToRoute('events');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("events/delete/{id}", name="delete_campus")
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function delete(Event $event, Request $request, EntityManagerInterface $em)
    {
        $event = $em->getRepository(Event::class)->find($request->get('id'));
        $em->remove($event);
        $em->flush();
        $this->addFlash('success', 'Event deleted.');
        
        return $this->redirectToRoute('events');
    }

    /**
     * @Route("/events/{id}", name="show_event")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ContactNotification $notification
     * @return Response
     */
    public function show(Request $request, EntityManagerInterface $em, ContactNotification $notification): Response
    {
        $eventData = $this->events = $em->getRepository(Event::class)->showQuery($request->get('id'));
        $event = $eventData[0];

        $contact = new Contact();
        $contact->setEvent($event);
        $form = $this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        $subscribers = $em->getRepository(Subscription::class)->findBy(['event' => $request->get('id')]);

        if($form->isSubmitted() and $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Your mail has been send');
//            return $this->redirectToRoute('show_event', [
//                'event' => $event,
//                'subscribers' => $subscribers
//            ]);
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'subscribers' => $subscribers,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/events/addSubscriber/{id}", name="add_subscriber_event")
     * @param EntityManagerInterface $em
     * @param Event $event
     * @return RedirectResponse
     */
    public function addSubscriber(EntityManagerInterface $em, Event $event): RedirectResponse
    {

        $user = $em->getRepository(User::class)->find($this->getUser()->getId());
        $subscription = new Subscription();
        $subscription->setSubscriptionDate(new DateTime());
        $subscription->setEvent($event);
        $subscription->setSubscriber($user);

        $em->persist($subscription);


        $em->flush();
        $this->addFlash('success', 'Subscription successful!');
        return $this->redirectToRoute('events');
    }

    /**
     * @Route("/events/removeSubscriber/{id}", name="remove_subscriber_event")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteSubscriber(EntityManagerInterface $em, Request $request): RedirectResponse
    {
        $user = $this->getUser();

        $event = $em->getRepository(Event::class)->find($request->get('id'));

        $inscription = $em->getRepository(Subscription::class)->findBy(['event' => $event->getId(), 'subscriber' => $user->getId()], ['event' => 'ASC']);
        $em->remove($inscription[0]);
        $em->flush();
        $this->addFlash('success', 'Subscription cancelled!');
        return $this->redirectToRoute('events');
    }

    /**
     * @Route("/events/cancel/{id}", name="cancel_event")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Event $event
     * @return RedirectResponse|Response
     */
    public function cancelEvent(Request $request, EntityManagerInterface $em, Event $event)
    {

        $user = $this->getUser();

        $form = $this->createForm(CancelEventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event->setDescription($form['description']->getData());
            $event->setState("Cancelled");

            $em->flush();
            $this->addFlash('success', 'Event cancelled!');

            $this->events = $em->getRepository(Event::class)->findAll();

            return $this->redirectToRoute('events');

        }


        return $this->render('event/cancel.html.twig', [
            'event' => $event,
            'users' => $user,
            'form' => $form->createView()
        ]);
    }

}
