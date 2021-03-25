<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Subscription;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @var EventRepository
     */
    private $repository;

    /**
     * @var null
     */
    private $event = null;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $events = $em->getRepository(Event::class)->homeQuery();
        $event = $events[0];
        $subscribers = $em->getRepository(Subscription::class)->findBy(['event'=>$request->get('id')]);
        return $this->render('main/home.html.twig', [
            'event' => $event,
//            'subscribers' => $subscribers
        ]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     * @param $locale
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeLocale($locale, Request $request): RedirectResponse
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }
}
