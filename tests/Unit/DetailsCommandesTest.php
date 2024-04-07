<?php

namespace App\Tests\Unit;

use App\Entity\Commandes;
use App\Entity\DetailsCommandes;
use App\Entity\Offres;
use PHPUnit\Framework\TestCase;

class DetailsCommandesTest extends TestCase
{
    public function testQuantiteGetterAndSetter(): void
    {
        $detailsCommandes = new DetailsCommandes();
        $this->assertNull($detailsCommandes->getQuantité());

        $detailsCommandes->setQuantité(5);
        $this->assertEquals(5, $detailsCommandes->getQuantité());
    }

    public function testPrixGetterAndSetter(): void
    {
        $detailsCommandes = new DetailsCommandes();
        $this->assertNull($detailsCommandes->getPrix());

        $detailsCommandes->setPrix(50);
        $this->assertEquals(50, $detailsCommandes->getPrix());
    }

    public function testCommandesGetterAndSetter(): void
    {
        $detailsCommandes = new DetailsCommandes();
        $this->assertNull($detailsCommandes->getCommandes());

        $commandes = new Commandes();
        $detailsCommandes->setCommandes($commandes);
        $this->assertEquals($commandes, $detailsCommandes->getCommandes());
    }

    public function testOffresGetterAndSetter(): void
    {
        $detailsCommandes = new DetailsCommandes();
        $this->assertNull($detailsCommandes->getOffres());

        $offres = new Offres();
        $detailsCommandes->setOffres($offres);
        $this->assertEquals($offres, $detailsCommandes->getOffres());
    }
}
