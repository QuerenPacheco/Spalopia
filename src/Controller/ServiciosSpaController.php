<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ServiciosSpaService;

class ServiciosSpaController extends AbstractController
{
   
    #[Route('/servicios', name: 'app_servicios_spa_listado')]
    public function index(ServiciosSpaService $serviciosSpaService): JsonResponse
    {
        $result = $serviciosSpaService->gestionListadoServicios();

        return $this->json([
            'servicios' => $result
        ]);
    }
    
}
