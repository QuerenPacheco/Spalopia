<?php
namespace App\Tests\Service;

use App\Entity\ServicioSpa;
use App\Repository\ServicioSpaRepository;
use App\Service\ServiciosSpaService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServicioSpaTest extends KernelTestCase
{
    public function testGetServicios(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $servicio = new ServicioSpa();
        $servicio->setNombre('masaje piernas');
        $servicio->setPrecio(25);
        $serviciosSpaRepo = $this->createMock(ServicioSpaRepository::class);
        $serviciosSpaRepo->expects(self::once())
            ->method('findAll')
            ->willReturn([
                $servicio
            ])
        ;
        $container->set(ServicioSpaRepository::class, $serviciosSpaRepo);

        $serviciosSpaService = $container->get(ServiciosSpaService::class);
        $servicios = $serviciosSpaService->getServicios();

        $this->assertEquals(1, count($servicios));
        $this->assertEquals(25, $servicios[0]->getPrecio());

    }
}