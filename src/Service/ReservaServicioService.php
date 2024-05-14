<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ReservaServicio;
use App\Repository\HorarioRepository;
use App\Repository\ReservaServicioRepository;
use App\Repository\ServicioSpaRepository;
use App\Service\ServiciosSpaService;
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
        $nuevaReserva = new ReservaServicio;
        $this->entityManager->persist($datos);
        $this->entityManager->flush();
    }

    public function gestionListadoReservas($fecha, $nombreServicio)
    {

        $fechaObj = new \DateTime($fecha);
        $idServicio = $this->serviciosSpaRepository->findOneBy(['nombre' => $nombreServicio])->getId();

        $horasDisponibles = $this->getHorasDisponibles($idServicio, $fechaObj);
        return $horasDisponibles;
    }

    function getHorasDisponibles($idServicio, $fechaObj)
    {
        $horarioServicio = $this->horarioRepository->findOneBy(['servicio' => $idServicio, 'dia' => $fechaObj]);
        $horaInicio = $horarioServicio->getHoraInicio();
        $horaFin = $horarioServicio->getHoraFin();

        $horasDeServicio = $horaInicio->diff($horaFin)->h;

        $horasDisponibles = [$horaInicio->format('H:i')];
        for ($i = 1; $i < $horasDeServicio; $i++) {
            array_push($horasDisponibles, $horaInicio->modify('+1 hours')->format('H:i'));
        }

        $horasDisponibles = $this->gestionHorasReservadas($idServicio, $fechaObj, $horasDisponibles);

        return $horasDisponibles;
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
        
        foreach ($serviciosEnFecha as $servicio) {
            $idServicio = $servicio->getId();
            $horasServicio = $this->getHorasDisponibles($idServicio, $fechaObj);        

        }
        if(isset($horasServicio)){
            return $horasServicio;
        }else{
            return 'No hay servicios disponibles para este día';
        }
    }

}
