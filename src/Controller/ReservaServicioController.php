<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\ReservaType;
use App\Repository\ReservaServicioRepository;
use App\Service\ReservaServicioService;
use App\Service\ServiciosSpaService;
use Symfony\Component\HttpFoundation\Response;

class ReservaServicioController extends AbstractController
{
    #[Route('/reserva', name: 'app_reserva_servicio')]
    public function crearReserva(Request $request, ServiciosSpaService $serviciosSpaService,  ReservaServicioService $reservaServicioService): Response 
    {
        $servicios = $serviciosSpaService->getServicios();
        $form = $this->createForm(ReservaType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $datosFormulario = $form->getData();
            $reservaServicioService->gestionDatosReserva($datosFormulario);

            return $this->redirectToRoute('app_reserva_servicio');
        }

        return $this->render('reservas/index.html.twig', [
            'form' => $form->createView(),
            'servicios' => json_encode($servicios)
        ]);
    }
    
    #[Route('/listado-horas-disponibles/{servicio}/{fecha}', name: 'app_horas_disponibles')]
    public function listarHoras($servicio, $fecha, ReservaServicioService $reservaServicioService): Response 
    {
        
        $horasDisponibles = $reservaServicioService->getListadoHoras($fecha, $servicio);
        
        return $this->render('listadoHorasDisponibles.html.twig', [
            'horasDisponibles' => $horasDisponibles,
            'servicio' => $servicio,
            'fecha' => $fecha
        ]);
    }

    #[Route('/comprobarFechaServicios/{fecha}/{idServicio}', name: 'app_fecha_disponible')]
    public function comprobarFechaServicios($fecha, $idServicio, ReservaServicioService $reservaServicioService): Response 
    {
        $fechaHorasDisponibles = $reservaServicioService->getServiciosEnFecha($fecha, $idServicio);
        return new JsonResponse($fechaHorasDisponibles);
    }
}
