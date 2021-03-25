<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    private $campusListe = null;

    /**
     * @Route("/campus", name="campus")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(EntityManagerInterface $em): Response
    {
        $this->campusListe = $em->getRepository(Campus::class)->findAll();

        return $this->render('admin/campus/index.html.twig', [
            'campus' => $this->campusListe
        ]);
    }

    /**
     * @Route("/campus/add" , name="add_campus")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function add(Request $request, EntityManagerInterface $em){
        $campus = new Campus();
        $form = $this->createForm(CampusType::class, $campus);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campus = $form->getData();
            $em->persist($campus);
            $em->flush();
            $this->addFlash('success', 'Campus created !');
            return $this->redirectToRoute('campus');
        }

        return $this->render('admin/campus/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/campus/{id}", name="edit_campus")
     * @param Campus $campus
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(campus $campus, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(campusType::class, $campus);
        $form->remove('submit');
        $form->add('submit',SubmitType::class, [
            'label' => 'Update campus',
            'attr' => [
                'class' => 'btn btn-primary w-100'
            ]
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $campus = $form->getData();

            $em->persist($campus);
            $em->flush();
            $this->addFlash('success', 'Campus updated !');

            $this->campusListe = $em->getRepository(campus::class)->findAll();

            return $this->redirectToRoute('campus');
        }

        return $this->render('admin/campus/edit.html.twig', [
            'campus' => $campus,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/campus/delete/{id}", name="delete_campus" , requirements={"id"="\d+"})
     * @param Campus $campus
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function delete(campus $campus, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $campus = $em->getRepository(campus::class)->find($request->get('id'));

        $em->remove($campus);
        $em->flush();
        $this->addFlash('success', 'Campus deleted.');

        return $this->redirectToRoute('campus');
    }
}
