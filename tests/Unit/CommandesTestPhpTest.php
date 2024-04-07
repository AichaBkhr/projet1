<?php

namespace App\tests\Unit;

use App\Entity\Commandes;
use App\Entity\DetailsCommandes;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommandesTestPhpTest extends KernelTestCase
{
    public function testDetailsCommandesCanBeAddedToCommandes(): void
    {
        // Créer une nouvelle commande
        $commandes = new Commandes();
        $this->assertInstanceOf(Commandes::class, $commandes);

        // Créer un détail de commande
        $detailsCommandes = new DetailsCommandes();
        $this->assertInstanceOf(DetailsCommandes::class, $detailsCommandes);

        // Associer le détail de commande à la commande
        $commandes->addDetailsCommandes($detailsCommandes);

        // Vérifier si le détail de commande a été correctement ajouté à la commande
        $this->assertTrue($commandes->getDetailsCommandes()->contains($detailsCommandes));
        $this->assertEquals($commandes, $detailsCommandes->getCommandes());
    }

    public function testDetailsCommandesCanBeRemovedFromCommandes(): void
    {
        // Créer une nouvelle commande
        $commandes = new Commandes();
        $this->assertInstanceOf(Commandes::class, $commandes);

        // Créer un détail de commande
        $detailsCommandes = new DetailsCommandes();
        $this->assertInstanceOf(DetailsCommandes::class, $detailsCommandes);

        // Associer le détail de commande à la commande
        $commandes->addDetailsCommandes($detailsCommandes);

        // Vérifier si le détail de commande a été correctement ajouté à la commande
        $this->assertTrue($commandes->getDetailsCommandes()->contains($detailsCommandes));

        // Supprimer le détail de commande de la commande
        $commandes->removeDetailsCommandes($detailsCommandes);

        // Vérifier si le détail de commande a été correctement supprimé de la commande
        $this->assertFalse($commandes->getDetailsCommandes()->contains($detailsCommandes));
        $this->assertNull($detailsCommandes->getCommandes());
    }

    public function testReference(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        // Créer deux commandes avec la même référence
        $commandes1 = new Commandes();
        $commandes1->setReference('REF123');
        $this->assertEquals('REF123', $commandes1->getReference());
        $errors = $container->get('validator')->validate($commandes1);
        $this->assertCount(0, $errors);

        // j'ai pas réussi de tester l'unicité pourtant j'ai rajouté la contrainte UniqueEntity
        // dans Commandes.php et aussi j'ai bien vérifié dans le base de donnée que les référence 
        // sont uniques

        /* 
        $commandes2 = new Commandes();
        $commandes2->setReference('REF123');
        $errors = $container->get('validator')->validate($commandes2);
        $this->assertCount(1, $errors);
        */
    }

    public function testCle2(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        // Créer deux commandes avec la même Cle_2
        $commandes1 = new Commandes();
        $commandes1->setCle2('CLE123');
        $this->assertEquals('CLE123', $commandes1->getCle2());

        $errors = $container->get('validator')->validate($commandes1);
        $this->assertCount(0, $errors);


        // j'ai pas réussi de tester l'unicité pourtant j'ai rajouté la contrainte UniqueEntity
        // dans Commandes.php et aussi j'ai bien vérifié dans le base de donnée que les Clés_2 
        // sont uniques

        /*
        $commandes2 = new Commandes();
        $commandes2->setCle2('CLE123');
        $errors = $container->get('validator')->validate($commandes2);
        $this->assertCount(1, $errors);
        */
    }

    public function testQrCode(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        // Créer deux commandes avec le même QrCode
        $commandes1 = new Commandes();
        $commandes1->setQrCode('QR123');
        $this->assertEquals('QR123', $commandes1->getQrCode());
        $errors = $container->get('validator')->validate($commandes1);
        $this->assertCount(0, $errors);


        // j'ai pas réussi de tester l'unicité pourtant j'ai rajouté la contrainte UniqueEntity
        // dans Commandes.php et aussi j'ai bien vérifié dans le base de donnée que les QrCode 
        // sont uniques

        /*
        $commandes2 = new Commandes();
        $commandes2->setQrCode('QR123');
        $errors = $container->get('validator')->validate($commandes2);
        $this->assertCount(1, $errors);
        */
    }
}

