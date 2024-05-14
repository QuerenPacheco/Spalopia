<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ReservaServicio;
use App\Repository\HorarioRepository;
use App\Repository\ReservaServicioRepository;
use App\Repository\ServicioSpaRepository;
use DateTime;

class ReservaServicioService
{
    private $entityManager;
    private $reservaServicioRepository;
    private $serviciosSpaRepository;
    private $horarioRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ReservaServicioRepository $reservaServicioRepository,
        ServicioSpaRepository $servicioSpaRepository,
        HorarioRepository $horarioRepository
    ) {
        $this->entityManager = $entityManager;
        $this->reservaServicioRepository = $reservaServicioRepository;
        $this->serviciosSpaRepository = $servicioSpaRepository;
        $this->horarioRepository = $horarioRepository;
    }

    public function gestionDatosReserva($datos)
    {
        $nuevaReserva = new ReservaServicio($datos);
        $nuevaReserva->setNombreCliente($datos['nombre_cliente']);
        $nuevaReserva->setEmailCliente($datos['email_cliente']);
        $nuevaReserva->setServicio($datos['servicio']);
        $nuevaReserva->setFecha($datos['fecha']);
        $nuevaReserva->setHora(new DateTime($datos['hora']));
        $this->entityManager->persist($nuevaReserva);
        $this->entityManager->flush();
    }

    public function getListadoHoras($fecha, $nombreServicio)
    {

        $fechaObj = new \DateTime($fecha);
        $idServicio = $this->serviciosSpaRepository->findOneBy(['nombre' => $nombreServicio])->getId();
        $horasDisponibles = $this->getHorasDisponibles($idServicio, $fechaObj);
        return $horasDisponibles;
    }
    
    function getHorasDisponibles($idServicio, $fechaObj)
    {
        $horarioServicio = $this->horarioRepository->findOneBy(['servicio' => $idServicio, 'dia' => $fechaObj]);
        
        if($horarioServicio){

            $horaInicio = $horarioServicio->getHoraInicio();
            $horaFin = $horarioServicio->getHoraFin();
    
            $horasDeServicio = $horaInicio->diff($horaFin)->h;
    
            $horasDisponibles = [$horaInicio->format('H:i')];
            for ($i = 1; $i < $horasDeServicio; $i++) {
                array_push($horasDisponibles, $horaInicio->modify('+1 hours')->format('H:i'));
            }
    
            $horasDisponibles = $this->gestionHorasReservadas($idServicio, $fechaObj, $horasDisponibles);

            return $horasDisponibles;
        }else{
            return [];
        }

        
    }

    function gestionHorasReservadas($idServicio, $fechaObj, $horasDisponibles)
    {
        $reservas = $this->reservaServicioRepository->findBy([
            'fecha' => $fechaObj,
            'servicio' => $idServicio,
        ]);

        $horasReservadas = array_map(function($reserva){
            return  $reserva->getHora()->format('H:i');
        }, $reservas);
        return array_values(array_diff($horasDisponibles, $horasReservadas));
    }

    function getServiciosEnFecha($fecha, $idServicio){
        $fechaObj = new \DateTime($fecha);
        $serviciosEnFecha = $this->horarioRepository->findBy(['dia' => $fechaObj, 'servicio' => $idServicio]);
        
        $horasServicio = [];
        foreach ($serviciosEnFecha as $servicio) {
            $idServicio = $servicio->getId();
            $horasServicio = $this->getHorasDisponibles($idServicio, $fechaObj);        

        }
        
        return $horasServicio;
        
    }

}
