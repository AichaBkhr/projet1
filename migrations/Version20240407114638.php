<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407114638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Ajouter une contrainte d'unicité sur la colonne Cle_2
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282CAEA34914 ON commandes (Cle_2)');
        
        // Ajouter une contrainte d'unicité sur la colonne QrCode
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282CAEA34915 ON commandes (Qr_Code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_35D4282CAEA34914');
        $this->addSql('DROP INDEX UNIQ_35D4282CAEA34915');

    }
}
