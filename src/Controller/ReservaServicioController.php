<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\ReservaType;
use App\Service\ReservaServicioService;
use App\Service\ServiciosSpaService;
use Symfony\Component\HttpFoundation\Response;

class ReservaServicioController extends AbstractController
{
    #[Route('/reserva', name: 'app_reserva_servicio')]
    public function crearReserva(ServiciosSpaService $serviciosSpaService): Response 
    {
        $servicios = $serviciosSpaService->getServicios();
        $form = $this->createForm(ReservaType::class);

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     // Procesar los datos del formulario

        //     return $this->redirectToRoute('exito');
        // }

        return $this->render('reservas/index.html.twig', [
            'form' => $form->createView(),
            'servicios' => $servicios
        ]);
    }
}
