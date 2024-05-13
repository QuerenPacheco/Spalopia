<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ReservaServicio;
use App\Repository\ReservaServiciosRepository;
use App\Service\ServiciosSpaService;


class ReservaServicioService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
   
}
