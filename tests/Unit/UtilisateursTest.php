<?php

namespace App\tests\Unit;
use App\Entity\Utilisateurs;
use DeepCopy\f004\UnclonableItem;
use PHPUnit\Framework\TestCase;

class UtilisateursTest extends TestCase{
    public function testEmailGetterSetter(): void {
        $utilisateur = new Utilisateurs();
        $this->assertNull($utilisateur->getEmail());
        $utilisateur->setEmail('test@gmail.fr');
        $this->assertEquals('test@gmail.fr', $utilisateur->getEmail());
    }

    public function testRolesGetterSetter(): void {
        $utilisateur = new Utilisateurs();
        $this->assertEquals(['ROLE_USER'], $utilisateur->getRoles()); //car c'est le role ar défaut 
        $utilisateur->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN','ROLE_USER'], $utilisateur->getRoles());
    }
    
    public function testMDPSSGetterSetter(): void{
        $utilisateur = new Utilisateurs();
        $utilisateur->setPassword('mdpss2024');
        $this->assertEquals('mdpss2024', $utilisateur->getPassword());
    }
    public function testNomUtilisateur(): void{
        $utilisateur = new Utilisateurs();
        $this->assertNull($utilisateur->getNomUtilisateur());
        $utilisateur->setNomUtilisateur('aicha boukhari');
        $this->assertEquals('aicha boukhari', $utilisateur->getNomUtilisateur());
    }

    public function testCle1(): void {
        $utilisateur = new Utilisateurs();
        $this->assertNull($utilisateur->getCle1());
        $utilisateur->setCle1('ABC123');
        $this->assertEquals('ABC123', $utilisateur->getCle1());
    }

    public function testIsVerified(): void {
        $utlisateur = new Utilisateurs();
        $this->assertFalse($utlisateur->getIsVerified());
        $utlisateur->setIsVerified(true);
        $this->assertTrue($utlisateur->getIsVerified());
    }
}