<?php

namespace App\Controller;

use App\Form\UpdateType;
use App\Repository\AutovoorraadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/update/{id}', name: 'app_update')]
    public function index($id, AutovoorraadRepository $autovoorraadRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $auto = $autovoorraadRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(UpdateType::class, $auto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $prijs = $form->get('prijs')->getData();
            $voorraad = $form->get('voorraad')->getData();

            $auto->setPrijs($prijs);
            $auto->setVoorraad($voorraad);

            $entityManager->persist($auto);
            $entityManager->flush();

//            dd($auto);

            $this->addFlash('success', 'Auto is gewijzigd!');
            return $this->redirectToRoute('app_car');
        }

        return $this->render('update/index.html.twig', [
            'auto' => $auto, 'car_form' => $form->createView()
        ]);
    }
}