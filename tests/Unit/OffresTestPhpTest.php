<?php

namespace App\tests\Unit;

use App\Entity\Offres;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OffresTestPhpTest extends KernelTestCase
{
    public function getEntityOffres(){
        return(new Offres())
            ->setType('test 1')
            ->setCapacite(3)
            ->setPrix(20);
    }
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $offre = $this->getEntityOffres();
        $errors = $container->get('validator')->validate($offre);
        $this->assertCount(0, $errors);
    }

    public function testTypeInvalid(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $offre = $this->getEntityOffres();
        $offre->setType('');
        
        $errors = $container->get('validator')->validate($offre);
        $this->assertCount(1, $errors);
    }

    public function testPrixInvalid(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $offre = $this->getEntityOffres();
        $offre->setPrix(-20.00);
        
        $errors = $container->get('validator')->validate($offre);
        $this->assertCount(1, $errors);
    }

    public function testCapaciteInvalid(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $offre = $this->getEntityOffres();
        $offre->setCapacite(-2);
        
        $errors = $container->get('validator')->validate($offre);
        $this->assertCount(1, $errors);
    }
}
