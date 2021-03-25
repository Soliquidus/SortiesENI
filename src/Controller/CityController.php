<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    private $cities = null;

    /**
     * @Route("/cities", name="cities")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(EntityManagerInterface $em): Response
    {
        $this->cities = $em->getRepository(City::class)->findAll();

        return $this->render('admin/city/index.html.twig', [
            'cities' => $this-> cities
        ]);
    }

    /**
     * @Route("/city/add", name="add_city")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function add(Request $request, EntityManagerInterface $em){
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->getData();
            $em->persist($city);
            $em->flush();
            $this->addFlash('success', 'City added !');
            return $this->redirectToRoute('cities');
        }

        return $this->render('admin/city/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/city/{id}", name="edit_city")
     * @param City $city
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(City $city, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CityType::class, $city);
        $form->remove('submit');
        $form->add('submit',SubmitType::class, [
            'label' => 'Update city',
            'attr' => [
                'class' => 'btn btn-primary w-100'
            ]
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $city = $form->getData();

            $em->persist($city);
            $em->flush();
            $this->addFlash('success', 'Ville mise à jour !');

            $this->cities = $em->getRepository(City::class)->findAll();

            return $this->redirectToRoute('cities');
        }

        return $this->render('admin/city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/city/delete/{id}", name="delete_city" , requirements={"id"="\d+"})
     * @param City $city
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function delete(City $city, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $city = $em->getRepository(City::class)->find($request->get('id'));

        $em->remove($city);
        $em->flush();
        $this->addFlash('success', 'Ville supprimée.');

        return $this->redirectToRoute('cities');
    }


}
