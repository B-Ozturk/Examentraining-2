<?php

namespace App\Controller;

use App\Entity\Autovoorraad;
use App\Form\AutoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class InsertCarController extends AbstractController
{
    #[Route('/insert', name: 'app_insert_car')]
    public function index(Environment $twig, Request $request, EntityManagerInterface $entityManager): Response
    {
        $auto = new Autovoorraad();

        $form = $this->createForm(AutoType::class, $auto);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $model = $form->get('model')->getData();
            $type = $form->get('type')->getData();
            $prijs = $form->get('prijs')->getData();
            $voorraad = $form->get('voorraad')->getData();
            $gewicht = $form->get('gewicht')->getData();

            if ($prijs > 10000){
                if ($voorraad >= 1){
                    if ($prijs % 2 == 0){
                        if ($gewicht % 2 == 0){
                            $auto->setPrijs($prijs);
                            $auto->setVoorraad($voorraad);

                            $entityManager->persist($auto);
                            $entityManager->flush();

                            $this->addFlash('success', $model . ' ' . $type .' is toegevoegd!');
                            return $this->redirectToRoute('app_car');
                        } else {
                            $this->addFlash('success', 'Gewicht is geen even getal!');
                            return $this->redirectToRoute('app_insert_car');
                        }
                    } else {
                        $this->addFlash('success', 'Prijs is geen even getal!');
                        return $this->redirectToRoute('app_insert_car');
                    }
                } else {
                    $this->addFlash('success', 'Voorraad is niet groter dan 1!');
                    return $this->redirectToRoute('app_insert_car');
                }
            } else {
                $this->addFlash('success', 'Prijs is niet hoger dan €10.000!');
                return $this->redirectToRoute('app_insert_car');
            }

        }

        return new Response($twig->render('insert_car/index.html.twig', ['carform' => $form->createView()]));
    }
}
