<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ServiciosSpaService;
use Symfony\Component\HttpFoundation\Response;

class ServiciosSpaController extends AbstractController
{
   
    #[Route('/servicios', name: 'app_servicios_spa_listado')]
    public function index(ServiciosSpaService $serviciosSpaService): Response
    {
        $servicios = $serviciosSpaService->gestionListadoServicios();

        return $this->render('listadoServicios.html.twig', [
            'servicios' => $servicios,
        ]);
    }
    
}
