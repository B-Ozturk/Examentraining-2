<?php

namespace App\Controller;

use App\Repository\AutovoorraadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/', name: 'app_car')]
    public function index(AutovoorraadRepository $autovoorraadRepository): Response
    {
        $autos = $autovoorraadRepository->findAll();

        return $this->render('car/index.html.twig', [
            'autos' => $autos,
        ]);
    }
}
