<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ServicioSpa;
use App\Repository\ServicioSpaRepository;

class ServiciosSpaService 
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function getServicios(): array
    {
        return $this->entityManager->getRepository(ServicioSpa::class)->findAll();
    }

    public function gestionListadoServicios(){

        $resultado = $this->getServicios();

        if(empty($resultado)){
            $resultado = 'No hay servicios de spa disponibles en este momento.'; 
        }
        return $resultado;
   }
}
