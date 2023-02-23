<?php

namespace App\Controller;

use App\Repository\AutovoorraadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_delete')]
    public function index($id, AutovoorraadRepository $autovoorraadRepository, EntityManagerInterface $entityManager): Response
    {
        $auto = $autovoorraadRepository->findOneBy(['id' => $id]);

        $entityManager->remove($auto);
        $entityManager->flush();

        $this->addFlash('success', $auto->getModel() . ' ' . $auto->getType() . ' is verwijderd!');
        return $this->redirectToRoute('app_car');
    }
}
