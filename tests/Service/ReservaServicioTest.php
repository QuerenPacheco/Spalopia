<?php
namespace App\Tests\Service;

use App\Entity\Horario;
use App\Entity\ReservaServicio;
use App\Entity\ServicioSpa;
use App\Repository\HorarioRepository;
use App\Repository\ReservaServicioRepository;
use App\Repository\ServicioSpaRepository;
use App\Service\ReservaServicioService;
use App\Service\ServiciosSpaService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class ReservaServicioTest extends KernelTestCase
{
    public function testGetListadoHoras(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $servicio = new ServicioSpa();
        $servicio->setNombre('masaje piernas');
        $servicio->setPrecio(25);
        $servicio->setId(1);
        $serviciosSpaRepo = $this->createMock(ServicioSpaRepository::class);
        $serviciosSpaRepo->expects(self::any())
            ->method('findOneBy')
            ->willReturn($servicio)
        ;

        $horario = new Horario();
        $horario->setDia(new DateTime('25-05-2024'));
        $x=(new DateTime('27-05-2024'));
        $horario->setHoraInicio(new DateTime('17:00:00'));
        $horario->setHoraFin(new DateTime('21:00:00'));
        $horario->setServicio($servicio);
        $horarioRepo = $this->createMock(HorarioRepository::class);
        $horarioRepo->expects(self::once())
            ->method('findOneBy')
            ->willReturn($horario)
        ;

        $reserva = new ReservaServicio();
        
        $reserva->setNombreCliente('Maria');
        $reserva->setEmailCliente('maria@gmail.com');
        $reserva->setFecha(new DateTime('25-05-2024'));
        $reserva->setHora(new DateTime('19:00:00'));
        $reserva->setServicio($servicio);
        $reservaRepo = $this->createMock(ReservaServicioRepository::class);
        $reservaRepo->expects(self::any())
            ->method('findBy')
            ->willReturn([
                $reserva
            ])
        ;
        $container->set(ReservaServicioRepository::class, $reservaRepo);
        $container->set(HorarioRepository::class, $horarioRepo);
        $container->set(ServicioSpaRepository::class, $serviciosSpaRepo);

        $reservaService = $container->get(ReservaServicioService::class);
        $listadoHoras = $reservaService->getListadoHoras('25-05-2024', 'masaje piernas');

        $this->assertEquals(3, count($listadoHoras));
        $this->assertEquals(["17:00", "18:00", "20:00"], $listadoHoras);

    }

    public function testGetListadoHorasVacio(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $servicio = new ServicioSpa();
        $servicio->setNombre('masaje piernas');
        $servicio->setPrecio(25);
        $servicio->setId(1);
        $serviciosSpaRepo = $this->createMock(ServicioSpaRepository::class);
        $serviciosSpaRepo->expects(self::any())
            ->method('findOneBy')
            ->willReturn($servicio)
        ;

        $horario = new Horario();
        $horario->setDia(new DateTime('25-05-2024'));
        $x=(new DateTime('27-05-2024'));
        $horario->setHoraInicio(new DateTime('17:00:00'));
        $horario->setHoraFin(new DateTime('21:00:00'));
        $horario->setServicio($servicio);
        $horarioRepo = $this->createMock(HorarioRepository::class);
        $horarioRepo->expects(self::once())
            ->method('findOneBy')
            ->willReturn(null)
        ;

        $reserva = new ReservaServicio();
        
        $reserva->setNombreCliente('Maria');
        $reserva->setEmailCliente('maria@gmail.com');
        $reserva->setFecha(new DateTime('25-05-2024'));
        $reserva->setHora(new DateTime('19:00:00'));
        $reserva->setServicio($servicio);
        $reservaRepo = $this->createMock(ReservaServicioRepository::class);
        $reservaRepo->expects(self::any())
            ->method('findBy')
            ->willReturn([])
        ;
        $container->set(ReservaServicioRepository::class, $reservaRepo);
        $container->set(HorarioRepository::class, $horarioRepo);
        $container->set(ServicioSpaRepository::class, $serviciosSpaRepo);

        $reservaService = $container->get(ReservaServicioService::class);
        $listadoHoras = $reservaService->getListadoHoras('27-05-2024', 'masaje piernas');

        $this->assertEquals(0, count($listadoHoras));
        $this->assertEquals([], $listadoHoras);

    }
}