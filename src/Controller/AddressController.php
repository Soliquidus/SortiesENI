<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    private $addresses = null;

    /**
     * @Route("/addresses", name="addresses")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function list(Request $request, EntityManagerInterface $em): Response
    {
        $this->addresses = $em->getRepository(Address::class)->addressIndex();

        return $this->render('admin/address/index.html.twig', [
            'addresses' => $this-> addresses
        ]);
    }

    /**
     * @Route("/address/add" , name="add_address")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function add(Request $request, EntityManagerInterface $em){
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em->persist($address);
            $em->flush();
            $this->addFlash('success', 'Address created !');
            return $this->redirectToRoute('addresses');
        }

        return $this->render('admin/address/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/address/{id}", name="edit_address")
     * @param Address $address
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Address $address, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->remove('submit');
        $form->add('submit',SubmitType::class, [
            'label' => 'Update address',
            'attr' => [
                'class' => 'btn btn-primary w-100'
            ]
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $address = $form->getData();

            $em->persist($address);
            $em->flush();
            $this->addFlash('success', 'Address updated!');

            $this->addresses = $em->getRepository(Address::class)->findAll();

            return $this->redirectToRoute('addresses');
        }

        return $this->render('admin/address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/address/delete/{id}", name="delete_address" , requirements={"id"="\d+"})
     * @param Address $address
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function delete(Address $address, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $address = $em->getRepository(Address::class)->find($request->get('id'));

        $em->remove($address);
        $em->flush();
        $this->addFlash('success', 'Adresse deleted!');

        return $this->redirectToRoute('addresses');
    }
}
