<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240113234348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateurs ALTER COLUMN is_verified TYPE BOOLEAN USING is_verified::boolean');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified TYPE BOOLEAN');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified TYPE BOOLEAN');
        $this->addSql('ALTER TABLE utilisateurs ALTER reset_token TYPE VARCHAR(100)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateurs ALTER reset_token TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified TYPE VARCHAR(100)');
    }
}
