<?php

namespace App\Controller;

use App\Form\UpdateType;
use App\Repository\AutovoorraadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    #[Route('/detail/{id}', name: 'app_detail')]
    public function index($id, AutovoorraadRepository $autovoorraadRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $auto = $autovoorraadRepository->findOneBy(['id' => $id]);
        $gewicht = $auto->getGewicht();

        if ($gewicht > 500){
            $belasting = 18;
        } elseif ($gewicht > 750) {
            $belasting = 22;
        } elseif ($gewicht > 1000) {
            $belasting = 40;
        } elseif ($gewicht > 1500) {
            $belasting = 60;
        }

        return $this->render('detail/index.html.twig', [
            'auto' => $auto, 'belasting' => $belasting
        ]);
    }
}